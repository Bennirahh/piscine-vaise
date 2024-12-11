<?php

namespace App\Controller\Front;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class EventManagementController extends AbstractController
{
    #[Route('/events', name: 'front_events')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        // Récupérez tous les événements depuis la base de données
        $events = $entityManager->getRepository(Event::class)->findAll();

        // Passez la variable 'events' à la vue
        return $this->render('event/show_events.html.twig', [
            'events' => $events,
        ]);
    }
}
