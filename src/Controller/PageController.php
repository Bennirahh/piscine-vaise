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

    #[Route('/profil', name: 'profil')]
    public function profil(): Response
    {
        return $this->render('profil.html.twig');
    }
    
    #[Route('/profiledit', name: 'profiledit')]
    public function profiledit(): Response
    {
        return $this->render('profiledit.html.twig');
    }

    #[Route('/probleme', name: 'probleme')]
    public function probleme(): Response
    {
        return $this->render('probleme.html.twig');
    }
}