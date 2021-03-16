<?php

namespace App\Controller;

use App\Form\TripForm;
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
     */
    public function new ()
    {
        $form = $this->createForm(TripForm::class);
        return $this->render('/pages/trip/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
