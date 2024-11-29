<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/users/crud')]
final class UsersCrudController extends AbstractController
{
    #[Route('/edit', name: 'app_users_crud_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, EntityManagerInterface $entityManager): Response
{
    $user = $this->getUser();

    if (!$user) {
        throw $this->createAccessDeniedException('Vous devez être connecté pour modifier votre profil.');
    }

    $form = $this->createForm(UsersType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('app_users_crud_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('users_crud/edit.html.twig', [
        'form' => $form,
    ]);
}

#[Route('/{id}', name: 'app_users_crud_show', methods: ['GET'])]
public function show(Users $user): Response
{
    return $this->render('users_crud/show.html.twig', [
        'user' => $user,
    ]);
}

}
