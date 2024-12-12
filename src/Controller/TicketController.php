<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TicketsRepository;

class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'app_ticket')]
    public function index(): Response
    {

         // Récupère les tickets depuis la base de données
        $tickets = $ticketsRepository->findAll();

        return $this->render('billetterie.html.twig', [
            'tickets' => $tickets,
        ]);
    }
}
