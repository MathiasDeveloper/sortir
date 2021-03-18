<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController
{
    /**
     * @Routes("/register/{id}", methods={"GET"})
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request): Response
    {
        return new Response('TODO: set message succes when user register on trip');
    }
}
