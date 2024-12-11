<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Event;
use App\Entity\Location;
use App\Entity\Equipement;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ReservationType;

class ReservationController extends AbstractController
{
    #[Route('/reservation/new', name: 'app_reservation')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser(); // Symfony prend ici l'utilisateur de l'application

        // Créez une nouvelle réservation
        $reservation = new Reservation();
        
        // Associez l'utilisateur à la réservation en utilisant setUsers()
        $reservation->setUsers($user);

        // Récupérer les événements, lieux et équipements
        $events = $entityManager->getRepository(Event::class)->findAll();
        $locations = $entityManager->getRepository(Location::class)->findAll();
        $equipments = $entityManager->getRepository(Equipement::class)->findAll();
        
        // Créer le formulaire avec les options
        $form = $this->createForm(ReservationType::class, $reservation, [
            'user' => $user,  // Passe l'utilisateur connecté au formulaire
            'events' => $events,
            'locations' => $locations,
            'equipements' => $equipments,
        ]);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $peopleNumber = $data->getReservationPeaopleNumber(); // Récupérer le nombre de personnes

            $totalPrice = 0; // Initialiser le prix total

            // Calcul du prix total en fonction de la catégorie et du nombre de personnes
            if ($data->getReservationCategory() === 'event' && $data->getEvent()) {
                $pricePerPerson = $data->getEvent()->getEventPrice();
                $totalPrice = $pricePerPerson * $peopleNumber;
            } elseif ($data->getReservationCategory() === 'location' && $data->getLocation()) {
                $pricePerPerson = $data->getLocation()->getLocationPrice();
                $totalPrice = $pricePerPerson * $peopleNumber;
            } elseif ($data->getReservationCategory() === 'equipement' && $data->getEquipement()) {
                $pricePerPerson = $data->getEquipement()->getEquipementPrice();
                $totalPrice = $pricePerPerson * $peopleNumber;
            }

            // Affecter le prix total à la réservation
            $reservation->setReservationPrice($totalPrice);

            // Enregistrer la réservation en base de données
            $entityManager->persist($reservation);
            $entityManager->flush();

            // Ajouter un message flash et rediriger
            $this->addFlash('success', 'Réservation créée avec succès.');
            return $this->redirectToRoute('reservation_list');
        }

        return $this->render('reservation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reservation', name: 'reservation_list')]
    public function list(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les réservations de l'utilisateur connecté
        $user = $this->getUser();
        $reservations = $user ? $user->getReservation() : [];

        // Créez un formulaire pour effectuer une nouvelle réservation
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);

        // Traitez la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Associez l'utilisateur à la réservation
            if ($user) {
                $reservation->setUsers($user); // Utilisez `setUsers()`
            }

            // Gestion de la catégorie de réservation
            $category = $reservation->getReservationCategory();
            if ($category === 'event') {
                $event = $form->get('event')->getData();
                $reservation->setEvent($event);
                $reservation->setLocation(null);
                $reservation->setEquipement(null);
            } elseif ($category === 'location') {
                $location = $form->get('location')->getData();
                $reservation->setLocation($location);
                $reservation->setEvent(null);
                $reservation->setEquipement(null);
            } elseif ($category === 'equipement') {
                $equipement = $form->get('equipement')->getData();
                $reservation->setEquipement($equipement);
                $reservation->setEvent(null);
                $reservation->setLocation(null);
            }

            // Enregistrez la réservation dans la base de données
            $entityManager->persist($reservation);
            $entityManager->flush();

            // Ajouter un message flash et redirigez
            $this->addFlash('success', 'Votre réservation a été enregistrée avec succès.');
            return $this->redirectToRoute('reservation_list');
        }

        // Rendre la liste des réservations et le formulaire
        return $this->render('reservation/list.html.twig', [
            'reservations' => $reservations,
            'form' => $form->createView(),
        ]);
    }
}
