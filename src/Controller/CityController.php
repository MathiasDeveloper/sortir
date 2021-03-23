<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Form\CitiesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CityController extends AbstractController
{
    /**
     * @Route("/villes", name="city_index")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cities = $entityManager->getRepository(City::class);
        $cities = $cities->findAll();
        $form = $this->createForm(CitiesType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cityRepo = $entityManager->getRepository(City::class);
            if ($form->get('submit')->isClicked()) {
                $search = $form->getData();

                $like = $search['search'];
                $like = trim($like);
                $cities = $cityRepo->findLikeByName($like);
            }
            if ($form->get('reset')->isClicked()) {
                $cities = $cityRepo->findAll();
            }

            return $this->render('pages/city/index.html.twig', [
                'cities' => $cities,
                'form'   => $form->createView(),
            ]);
        }

        return $this->render('pages/city/index.html.twig', [
            'cities' => $cities,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/villes/create", name="city_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CityType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $city = $form->getData();

            $entityManager->persist($city);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Ville créée'
            );

            return $this->redirectToRoute('city_index');
        }

        return $this->render('pages/city/create.html.twig', [
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/villes/edit/{id}", name="city_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $city = $entityManager->getRepository(City::class);
        $city = $city->findOneBy(['id' => $id]);
        $form = $this->createForm(CityType::class, $city);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $city = $form->getData();

            $entityManager->persist($city);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Ville modifiée'
            );

            return $this->redirectToRoute('city_index');
        }

        return $this->render('pages/city/create.html.twig', [
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/villes/delete/{id}", name="city_delete")
     */
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $city = $entityManager->getRepository(City::class);
        $city = $city->findOneBy(['id' => $id]);

        $entityManager->remove($city);
        $entityManager->flush();

        return $this->redirectToRoute('city_index');
    }
}
