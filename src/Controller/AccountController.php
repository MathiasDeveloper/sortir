<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\Participant;
use App\Form\UpdatePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/editer-profil", name="profile_edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        $form_user = $this->createForm(UserType::class, $user);
        $form_password = $this->createForm(UpdatePasswordType::class);

        $flash_message = 'Your changes were saved!';
        $form_user->handleRequest($request);
        if ($form_user->isSubmitted() && $form_user->isValid()) {
            $userData = $form_user->getData();

            // photo management
            $coverFile = $request->files->get('user')['photoUrl'];
            if ($coverFile) {
                $filesystem = new Filesystem();
                $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$coverFile->guessExtension();
                $coverFile->move(
                    $this->getParameter('user_photos_directory'),
                    $newFilename
                );

                $old_picture = $user->getPhotoUrlRaw();
                if ($filesystem->exists("uploads/photos/$old_picture")) {
                    $filesystem->remove("uploads/photos/$old_picture");
                }

                $user->setPhotoUrl($newFilename);
            }

            $entityManager->persist($userData);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                $flash_message
            );

            return $this->redirectToRoute('profile_edit');
        }
        $form_password->handleRequest($request);
        if ($form_password->isSubmitted() && $form_password->isValid()) {
            $userData = $form_password->getData();
            $current_password = $userData['current_password'];
            $user = $this->getUser();
            $checkPass = $passwordEncoder->isPasswordValid($user, $current_password);

            if (true === $checkPass) {
                $new_pwd = $userData['new_password'];
                $new_pwd_confirm = $userData['new_confirm_password'];
                if ($new_pwd === $new_pwd_confirm) {
                    $password = $passwordEncoder->encodePassword($user, $new_pwd);
                    $user->setPassword($password);

                    $entityManager->persist($user);
                    $entityManager->flush();

                    $flash_message = 'Password updated!';
                } else {
                    $flash_message = 'Password not match!';
                }
            } else {
                $flash_message = 'Current password is not correct!';
            }

            $this->addFlash(
                'notice',
                $flash_message
            );

            return $this->redirectToRoute('profile_edit');
        }

        return $this->render('pages/profile/edit.html.twig', [
            'form_user'     => $form_user->createView(),
            'form_password' => $form_password->createView(),
            // 'user'      => $user,
        ]);
    }

    /**
     * @Route("/profil/{id}", name="profile_show")
     */
    public function show(Request $request, int $id, EntityManagerInterface $entityManager)
    {
        $user = $entityManager->getRepository(Participant::class);
        $user = $user->findOneBy(['id' => $id]);

        return $this->render('pages/profile/show.html.twig', [
            'user'      => $user,
        ]);
    }
}
