<?php 

// src/Controller/Front/ReservationController.php

namespace App\Controller\Front;

use App\Entity\Event;
use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ReservationController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/event/{id}/reserve', name: 'event_reserve')]
    public function reserve(Event $event, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $reservation = new Reservation();

            // Récupération des données du formulaire
            $peopleNumber = $request->request->get('reservation_people_number');
            $reservationCategory = $request->request->get('reservation_category');

            // Vérifiez si les valeurs ne sont pas nulles
            if ($peopleNumber === null || $reservationCategory === null) {
                throw new \Exception('Veuillez fournir toutes les informations requises.');
            }

            // Assurez-vous de définir toutes les propriétés nécessaires de la réservation
            $reservation->setReservationPeaopleNumber((int)$peopleNumber);
            $reservation->setReservationCategory($reservationCategory);
            $reservation->setEvent($event); // Associez la réservation à l'événement
            
            // Définir la date de réservation
            $reservation->setReservationDate(new \DateTime()); 

            // Définir le prix de réservation en fonction du prix de l'événement
            $reservation->setReservationPrice($event->getEventPrice()); // Assurez-vous d'avoir une méthode setReservationPrice

            // Persister l'objet réservation
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();

            return $this->redirectToRoute('reservation_success'); // Redirection après succès
        }

        return $this->render('front/event/reserve.html.twig', [
            'event' => $event,
        ]);
    }
    // src/Controller/Front/ReservationController.php

#[Route('/reservation/success', name: 'reservation_success')]
public function success(): Response
{
    return $this->render('front/reservation/success.html.twig'); // Créez un template pour afficher le succès
}

}
