<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripForm;
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
        return $this->render('/pages/trip/index.html.twig', [
            'controller_name' => 'TripController',
        ]);
    }

    /**
     * @Route("/trip/new", name="newTrip")
     *
     * @param Request $request
     * @return Response
     */
    public function new (Request $request): Response
    {

        $form = $this->createForm(TripForm::class);
        $trip = new Trip();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trip = $form->getData();
            return $this->redirectToRoute('task_success');
        }

        return $this->render('/pages/trip/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
