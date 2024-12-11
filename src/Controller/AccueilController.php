<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les données dans la base
            $entityManager->persist($contact);
            $entityManager->flush();

            // Message de succès
            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            // Redirection (évite de resoumettre le formulaire si la page est rechargée)
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('accueil.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
