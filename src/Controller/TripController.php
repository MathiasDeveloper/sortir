<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Trip;
use App\Form\TripForm;
use App\Form\TripsType;
use App\Entity\Participant;
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
     * @Route("/sorties", name="trip")
     */
    public function index(Request $request, DataTableFactory $dataTableFactory, EntityManagerInterface $entityManager): Response
    {
        // $tripsTable = $dataTableFactory->create()
        // ->add('name', TextColumn::class, [
        //     'label'            => 'Nom de la sortie',
        //     'orderable'        => true,
        //     'searchable'       => true,
        //     'globalSearchable' => true,
        // ])
        // ->add('begin_date', DateTimeColumn::class, [
        //     'label'     => 'Date de la sortie',
        //     'format'    => 'd/m/Y',
        //     'orderable' => true,
        // ])
        // ->add('end_date', DateTimeColumn::class, [
        //     'label'     => 'Clôture',
        //     'format'    => 'd/m/Y',
        // ])
        // ->add('state', TextColumn::class, [
        //     'label' => 'inscrits/places',
        // ])
        // ->add('state', TextColumn::class, [
        //     'label' => 'Etat',
        // ])
        // ->add('state', TextColumn::class, [
        //     'label' => 'Inscrit',
        // ])
        // ->add('organisor', TextColumn::class, [
        //     'label' => 'Organisateur',
        // ])
        // ->add('state', TextColumn::class, [
        //     'label' => 'Actions',
        // ])
        // ->createAdapter(ORMAdapter::class, [
        //     'entity' => Trip::class,
        //     'query'  => function (QueryBuilder $builder) {
        //         $builder->select('t')
        //                 ->from(Trip::class, 't')
        //                 ->orderBy('t.name', 'ASC');
        //     },
        // ])
        // ->createAdapter(ElasticaAdapter::class, [
        //     'client' => ['host' => 'elasticsearch'],
        //     'index'  => 'logstash-*',
        // ])
        // ->handleRequest($request);

        // if ($tripsTable->isCallback()) {
        //     return $tripsTable->getResponse();
        // }

        $tripRepository = $this->getDoctrine()->getRepository(Trip::class);
        $trips = $tripRepository->findAllWithRelations();

        $participant = $entityManager->getRepository(Participant::class);
        $participant = $participant->loadUserByUsername($this->getUser()->getUsername());
        $form = $this->createForm(TripsType::class);

        // dd($trips);
        // dd($participant->getSubscriptions()->count());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();

            // site
            $site_name = $search['site']->getName();
            $site = $entityManager->getRepository(Site::class)->findOneBy(['name' => $site_name]);
            $site = $site ? $site->getName() : null;

            // name wild card
            $like = $search['search'];
            $like = trim($like);
            $like = $like ? $like : null;

            // dates
            $begindate = $search['begin_date'];
            $enddate = $search['end_date'];

            // checkboxes
            $selforganisor = filter_var($search['self_organisor'], FILTER_VALIDATE_BOOLEAN);
            $selfsubscription = filter_var($search['self_subscription'], FILTER_VALIDATE_BOOLEAN);
            $selfunsubscription = filter_var($search['self_unsubscription'], FILTER_VALIDATE_BOOLEAN);
            $endtrips = filter_var($search['end_trips'], FILTER_VALIDATE_BOOLEAN);

            $currentUser = $this->getUser();

            $trips = $tripRepository->findAllSearch($site, $like, $begindate, $enddate, $selforganisor, $selfsubscription, $selfunsubscription, $endtrips, $currentUser);
            // dd($trips);

            return $this->render('pages/trip/index.html.twig', [
                'trips'       => $trips,
                'participant' => $participant,
                'form'        => $form->createView(),
            ]);
        }

        return $this->render('pages/trip/index.html.twig', [
            'trips'       => $trips,
            'participant' => $participant,
            'form'        => $form->createView(),
        ]);
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
