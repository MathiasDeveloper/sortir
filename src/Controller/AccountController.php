<?php

namespace App\Controller;

use App\Form\UserType;
use App\Form\UpdatePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $form_user = $this->createForm(UserType::class, $user);
        $form_password = $this->createForm(UpdatePasswordType::class);

        $flash_message = 'Your changes were saved!';
        $form_user->handleRequest($request);
        if ($form_user->isSubmitted() && $form_user->isValid()) {
            $userData = $form_user->getData();
            $entityManager->persist($userData);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                $flash_message
            );

            return $this->redirectToRoute('profile');
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

            return $this->redirectToRoute('profile');
        }

        return $this->render('pages/profile/index.html.twig', [
            'form_user'     => $form_user->createView(),
            'form_password' => $form_password->createView(),
            // 'user'      => $user,
        ]);
    }
}
