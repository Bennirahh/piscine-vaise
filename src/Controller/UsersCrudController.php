<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users/crud')]
final class UsersCrudController extends AbstractController
{
    #[Route('/edit', name: 'app_users_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();

        // Si l'utilisateur n'est pas connecté, on l'empêche de modifier son profil
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour modifier votre profil.');
        }

        // Crée le formulaire avec les données de l'utilisateur connecté
        $form = $this->createForm(UsersType::class, $user);

        // Gère la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            // Vérifie si des modifications ont été apportées
            if ($user !== $this->getUser()) {
                $this->addFlash('error', 'Les informations n\'ont pas pu être mises à jour.');
            } else {
                // Si le formulaire est valide, on persiste les modifications dans la base
                $entityManager->flush(); // Persiste les modifications en base de données

                // Affiche un message de succès
                $this->addFlash('success', 'Profil mis à jour avec succès.');

                // Redirige l'utilisateur vers une autre page après la mise à jour
                return $this->redirectToRoute('profil');
            }
        }

        // Rendu du formulaire dans une vue
        return $this->render('users_crud/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_users_crud_show', methods: ['GET'])]
    public function show(Users $user): Response
    {
        // Rendu d'une vue pour afficher le profil de l'utilisateur
        return $this->render('users_crud/show.html.twig', [
            'user' => $user,
        ]);
    }
}
