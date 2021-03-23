<?php

namespace App\Controller;

use App\Entity\Place;
use App\Form\PlaceType;
use App\Form\CitiesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlaceController extends AbstractController
{
    /**
     * @Route("/lieux", name="place_index")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $places = $entityManager->getRepository(Place::class);
        $places = $places->findAll();
        $form = $this->createForm(CitiesType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $placeRepo = $entityManager->getRepository(Place::class);
            if ($form->get('submit')->isClicked()) {
                $search = $form->getData();

                $like = $search['search'];
                $like = trim($like);
                $places = $placeRepo->findLikeByName($like);
            }
            if ($form->get('reset')->isClicked()) {
                $places = $placeRepo->findAll();
            }

            return $this->render('pages/place/index.html.twig', [
                'places' => $places,
                'form'   => $form->createView(),
            ]);
        }

        return $this->render('pages/place/index.html.twig', [
            'places' => $places,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/villes/create", name="place_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlaceType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $place = $form->getData();

            $entityManager->persist($place);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Lieu créée'
            );

            return $this->redirectToRoute('place_index');
        }

        return $this->render('pages/place/create.html.twig', [
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/villes/edit/{id}", name="place_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $place = $entityManager->getRepository(Place::class);
        $place = $place->findOneBy(['id' => $id]);
        $form = $this->createForm(PlaceType::class, $place);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $place = $form->getData();

            $entityManager->persist($place);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Lieu modifiée'
            );

            return $this->redirectToRoute('place_index');
        }

        return $this->render('pages/place/create.html.twig', [
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/villes/delete/{id}", name="place_delete")
     */
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $place = $entityManager->getRepository(Place::class);
        $place = $place->findOneBy(['id' => $id]);

        $entityManager->remove($place);
        $entityManager->flush();

        return $this->redirectToRoute('place_index');
    }
}
