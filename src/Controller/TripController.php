<?php

namespace App\Controller;

use App\Entity\Trip;
use Doctrine\ORM\QueryBuilder;
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
     * @Route("/sorties", name="trip_index")
     */
    public function index(Request $request, DataTableFactory $dataTableFactory): Response
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
}
