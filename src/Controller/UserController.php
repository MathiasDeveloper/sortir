<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/utilisateurs", name="user_index")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $participants = $entityManager->getRepository(Participant::class);
        $participants = $participants->findAll();

        return $this->render('pages/user/index.html.twig', [
            'participants' => $participants,
        ]);
    }

    /**
     * @Route("/admin/utilisateurs/create", name="user_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $participant = $form->getData();

            $participant->setRoles(['ROLE_USER']);
            $participant->setAdministrator(false);
            $participant->setActive(true);
            $name = $participant->getUsername();
            $participant->setPhotoUrl("https://eu.ui-avatars.com/api/?name=$name");

            $entityManager->persist($participant);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Utilisateur créé'
            );

            return $this->redirectToRoute('user_index');
        }

        return $this->render('pages/user/create.html.twig', [
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/utilisateurs/status/{id}", name="user_status")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $participant = $entityManager->getRepository(Participant::class);
        $participant = $participant->findOneBy(['id' => $id]);
        $status = $participant->getActive();

        if ($status) {
            $participant->setActive(false);
        } else {
            $participant->setActive(true);
        }
        $entityManager->persist($participant);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Mise à jour effectuée'
        );

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/admin/utilisateurs/delete/{id}", name="user_delete")
     */
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $participant = $entityManager->getRepository(Participant::class);
        $participant = $participant->findOneBy(['id' => $id]);

        $entityManager->remove($participant);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Utilisateur supprimé'
        );

        return $this->redirectToRoute('user_index');
    }
}
