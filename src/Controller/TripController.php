<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Enums\StateTypeEnum;
use App\Form\TripForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends AbstractController
{
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
     * @param Request $request
     * @param EntityManagerInterface $entityManager
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
                'form' => $form->createView()
            ]
        );
    }
}
