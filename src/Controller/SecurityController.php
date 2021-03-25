<?php

namespace App\Controller;

use App\Form\AdressMailType;
use App\Form\LoginType;
use App\Entity\Participant;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Translation\TranslatableMessage;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(LoginType::class);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $em
    ) {
        $user = new Participant();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Your account has been created!');

            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/reset-password", name="resetPassword")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws \Exception
     */
    public function forgotPassword(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        $form = $this->createForm(AdressMailType::class);
        $form->handleRequest($request);

        $user = null;
        $data = [];
        $link = "";
        $token = bin2hex(random_bytes(16));
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            /** @var Participant $user */
            $user = $entityManager->getRepository(
                Participant::class
            )->findOneBy(['email' => $data['emailAdress']]);
            $link = $this->generateUrl(
                'resetPassword',
                ['token' => $token, 'email' => $data['emailAdress']]
            );
        }

        if (null === $user && $form->isSubmitted()) {
            $this->addFlash(
                'warning',
                new TranslatableMessage(
                    sprintf(
                        'this email adress: %s not exist',
                        $data['emailAdress']
                    )
                )
            );
        }

        $formResetPassword = $this->createForm(ResetPasswordType::class);
        $formResetPassword->handleRequest($request);

        if ($request->query->get('token') && $formResetPassword->isSubmitted() && $formResetPassword->isValid()) {
            $data = $formResetPassword->getData();
            /** @var Participant $user */
            $user = $entityManager->getRepository(
                Participant::class
            )->findOneBy(['email' => $request->query->get('email')]);
            $password = $passwordEncoder->encodePassword($user, $data['password']);
            $user->setPassword($password);
            $entityManager->flush();
            $this->addFlash('notice', new TranslatableMessage('your password is updated'));
            return $this->redirectToRoute('app_login');
        };

        return $this->render(
            'security/reset_password.html.twig',
            [
                'form' => $form->createView(),
                'link' => $link,
                'user' => $user,
                'form_reset_password' => $formResetPassword->createView()
            ]
        );
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank.');
    }
}
