<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PageController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('login.html.twig');
    }
    
    #[Route('/profil', name: 'profil')]
    public function profil(Request $request): Response
    {
        $user = $this->getUser();

        // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
        if (!$user) {
            return $this->redirectToRoute('login');
        }

        return $this->render('profil.html.twig', [
            'user' => $user,
        ]);
    }
    
    #[Route('/profiledit', name: 'profiledit')]
    public function profiledit(): Response
    {
        return $this->render('profiledit.html.twig');
    }

    #[Route('/credits', name: 'credits')]
    public function credit(): Response
    {
        return $this->render('credits.html.twig');
    }

    #[Route('/rgpd', name: 'rgpd')]
    public function rgpd(): Response
    {
        return $this->render('mention.html.twig');
    }

    #[Route('/accueil', name: 'accueil')]
    public function accueil(): Response
    {
        return $this->render('accueil.html.twig');
    }
}
