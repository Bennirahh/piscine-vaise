<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Event;
use App\Entity\Location;
use App\Entity\Equipement;
use App\Entity\Tickets;

use Doctrine\ORM\EntityManagerInterface;

class billetterieController extends AbstractController{
    #[Route('/billetterie', name: 'billetterie')]
    public function billetterie(EntityManagerInterface $entityManager): Response
    {
        $events = $entityManager->getRepository(Event::class)->findAll();
        $locations = $entityManager->getRepository(Location::class)->findAll();
        $equipements = $entityManager->getRepository(Equipement ::class)->findAll();
        $tickets = $entityManager->getRepository(Tickets::class)->findAll();

        return $this->render('billetterie.html.twig',[
            'events'=>$events,
            'locations'=>$locations,
            'equipements'=>$equipements,
            'tickets' => $tickets

        ]);
    }
}

