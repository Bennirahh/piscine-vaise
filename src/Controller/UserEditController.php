<?php 

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class UserEditController extends AbstractController
{
    #[Route('/user/edit', name: 'app_user_edit')]
    public function editProfile(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour modifier vos informations.');
        }

        // Créer le formulaire pour l'édition du profil
        $form = $this->createForm(UserType::class, $user);

        // Traiter la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si un mot de passe a été soumis
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

            // Enregistrer les modifications dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Ajouter un message flash de succès
            $this->addFlash('success', 'Vos informations ont été mises à jour avec succès.');

            // Rediriger après la mise à jour
            return $this->redirectToRoute('profil'); // Changez cette ligne pour rediriger vers /profil
        }

        // Afficher le formulaire d'édition
        return $this->render('user_edit/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
