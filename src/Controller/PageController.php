<?php

// src/Controller/PageController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationFormType; // Ajoutez cette ligne pour inclure votre formulaire
use Symfony\Component\HttpFoundation\Request;

class PageController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('login.html.twig');
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request): Response
    {
        $form = $this->createForm(RegistrationFormType::class); // Créez le formulaire

        return $this->render('register.html.twig', [
            'registrationForm' => $form->createView(), // Passez le formulaire à la vue
        ]);
    }
}
