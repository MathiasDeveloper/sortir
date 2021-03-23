<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
use App\Form\CitiesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteController extends AbstractController
{
    /**
     * @Route("/sites", name="site_index")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sites = $entityManager->getRepository(Site::class);
        $sites = $sites->findAll();
        $form = $this->createForm(CitiesType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $siteRepo = $entityManager->getRepository(Site::class);
            if ($form->get('submit')->isClicked()) {
                $search = $form->getData();

                $like = $search['search'];
                $like = trim($like);
                $sites = $siteRepo->findLikeByName($like);
            }
            if ($form->get('reset')->isClicked()) {
                $sites = $siteRepo->findAll();
            }

            return $this->render('pages/site/index.html.twig', [
                'sites'  => $sites,
                'form'   => $form->createView(),
            ]);
        }

        return $this->render('pages/site/index.html.twig', [
            'sites'  => $sites,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/sites/create", name="site_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SiteType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $site = $form->getData();

            $entityManager->persist($site);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Site créé'
            );

            return $this->redirectToRoute('site_index');
        }

        return $this->render('pages/site/create.html.twig', [
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/sites/edit/{id}", name="site_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $site = $entityManager->getRepository(Site::class);
        $site = $site->findOneBy(['id' => $id]);
        $form = $this->createForm(SiteType::class, $site);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $site = $form->getData();

            $entityManager->persist($site);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Site modifié'
            );

            return $this->redirectToRoute('site_index');
        }

        return $this->render('pages/site/create.html.twig', [
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/sites/delete/{id}", name="site_delete")
     */
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $site = $entityManager->getRepository(Site::class);
        $site = $site->findOneBy(['id' => $id]);

        $entityManager->remove($site);
        $entityManager->flush();

        return $this->redirectToRoute('site_index');
    }
}
