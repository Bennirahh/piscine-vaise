<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('login.html.twig');
    }

    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('register.html.twig');
    }

    #[Route('/billetterie', name: 'billetterie')]
    public function billetterie(): Response
    {
        return $this->render('billetterie.html.twig');
    }

    #[Route('/accueil', name: 'accueil')]
    public function accueil(): Response
    {
        return $this->render('accueil.html.twig');
    }
}
