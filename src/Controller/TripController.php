<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripForm;
use App\Enums\StateTypeEnum;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Component\HttpFoundation\Request;
use Omines\DataTablesBundle\Column\TextColumn;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TripController extends AbstractController
{
    /**
     * @Route("/sorties", name="trip_filter")
     */
    public function filter(Request $request, DataTableFactory $dataTableFactory): Response
    {
        $tripsTable = $dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'label'            => 'Nom',
                'orderable'        => true,
                'globalSearchable' => true,
            ])
            ->add('begin_date', DateTimeColumn::class, [
                'label'     => 'Date de début',
                'format'    => 'd M Y',
                'orderable' => true,
            ])
            ->add('end_date', DateTimeColumn::class, ['label' => 'Date de fin'])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Trip::class,
                'query'  => function (QueryBuilder $builder) {
                    $builder->select('t')
                            ->from(Trip::class, 't')
                            ->orderBy('t.name', 'ASC');
                },
            ])
            ->handleRequest($request);

        if ($tripsTable->isCallback()) {
            return $tripsTable->getResponse();
        }

        return $this->render('pages/trips/index.html.twig', [
            'datatable' => $tripsTable,
        ]);
    }

    /**
     * @Route("/trip", name="trip")
     */
    public function index(): Response
    {
        return $this->render(
            '/pages/trip/index.html.twig',
            [
                'controller_name' => 'TripController',
            ]
        );
    }

    /**
     * @Route("/trip/new", name="newTrip")
     *
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TripForm::class);

        $form->handleRequest($request);

        $states = StateTypeEnum::getAvailableTypes();
        $state = $states[0];

        if ($form->isSubmitted() && $form->isValid()) {
            if (array_key_exists('send', $request->request->get('trip_form'))) {
                $state = $states[1];
            }

            /** @var Trip $trip */
            $trip = $form->getData();

            $trip->setState($state);
            $entityManager->persist($trip);
            $entityManager->flush();
        }

        return $this->render(
            '/pages/trip/new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
