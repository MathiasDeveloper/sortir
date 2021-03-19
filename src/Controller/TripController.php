<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Trip;
use App\Entity\Place;
use App\Form\TripForm;
use App\Form\TripsType;
use App\Entity\Participant;
use App\Enums\StateTypeEnum;
use App\Trip\Constant\Constant;
use DateTime;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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

        // if user is not connected redirect to login page
        if (!$this->getUser()){
            return $this->redirect('/login');
        }

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

            /** @var array<Trip> $trips */
            $trips = $tripRepository->findAllSearch($site, $like, $begindate, $enddate, $selforganisor, $selfsubscription, $selfunsubscription, $endtrips, $currentUser);

            // if endDate is late new state for trip on closed
            array_filter($trips, function ($trip) {
                $this->closedTrip($trip);
            });
            $entityManager->flush();

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
        $places = $entityManager->getRepository(Place::class);
        $places = $places->findAll();

        $form->handleRequest($request);

        $states = StateTypeEnum::getAvailableTypes();
        $state = $states[Constant::TYPE_CREATED];

        if ($form->isSubmitted() && $form->isValid()) {
            if (array_key_exists('send', $request->request->get('trip_form'))) {
                $state = $states[Constant::TYPE_OPENED];
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
                'form'   => $form->createView(),
                'places' => $places,
            ]
        );
    }

    /**
     * @Route("/sorties/{id}", name="trip_show")
     */
    public function show(EntityManagerInterface $entityManager, int $id)
    {
        $tr = $entityManager->getRepository(Trip::class);
        $current_trip = $tr->findOneBy(['id' => $id]);

        return $this->render('pages/trip/show.html.twig', [
            'trip'       => $current_trip,
        ]);
    }

    /**
     * @Route("/sorties/edit/{id}", name="trip_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id)
    {
        $tr = $entityManager->getRepository(Trip::class);
        $current_trip = $tr->findOneBy(['id' => $id]);
        $places = $entityManager->getRepository(Place::class);
        $places = $places->findAll();

        $form = $this->createForm(TripForm::class, $current_trip);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trip = $form->getData();

            $entityManager->persist($trip);
            $entityManager->flush();

            if ($form->get('save')->isClicked()) {
                return $this->redirectToRoute('trip');
            }
            if ($form->get('send')->isClicked()) {
                $trip->setState(StateTypeEnum::TYPE_OPENED);

                $entityManager->persist($trip);
                $entityManager->flush();
            }
            if ($form->get('delete')->isClicked()) {
                dump('delete');
            }
            if ($form->get('cancel')->isClicked()) {
                return $this->redirect($request->server->get('HTTP_REFERER'));
            }
        }

        return $this->render('pages/trip/edit.html.twig', [
            'form'       => $form->createView(),
            'trip'       => $current_trip,
            'places'     => $places,
        ]);
    }

    /**
     * @param Trip $trip
     * @throws Exception
     */
    public function closedTrip(Trip &$trip): void
    {
        if ($trip->getEndDate() > new DateTime('now')){
            $trip->setState(StateTypeEnum::getAvailableTypes()[Constant::TYPE_CLOSED]);
        }
    }

    /**
     * @Route("/sorties/close/{id}", name="close_trip", methods={"GET"})
     *
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return Response
     */
    public function cancel(EntityManagerInterface $entityManager, int $id): Response
    {
        /** @var Trip $trip */
        $trip = $entityManager->getRepository(Trip::class)->find($id);
        $trip->setState(StateTypeEnum::getAvailableTypes()[Constant::TYPE_CANCELED]);
        return $this->redirectToRoute('trip');
    }
}
