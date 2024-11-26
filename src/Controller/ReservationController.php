<?php 

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Event;
use App\Entity\Location;
use App\Entity\Equipement;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ReservationType;
use Symfony\Component\Form\FormBuilderInterface; // Pour créer et manipuler des formulaires
use Symfony\Component\Form\Extension\Core\Type\TextType; // Pour le type de champ texte
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Pour les boutons de soumission
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // Pour les champs de type choix (par exemple, une liste déroulante)
use Symfony\Component\Form\Extension\Core\Type\DateType; // Pour les champs de type date
use Symfony\Component\Form\FormTypeInterface; // Pour la déclaration du type de formulaire


class ReservationController extends AbstractController
{
    #[Route('/reservation/new', name: 'app_reservation')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
      
        $reservation = new Reservation();

        $events = $entityManager->getRepository(Event::class)->findAll();
        $locations = $entityManager->getRepository(Location::class)->findAll();
        $equipments = $entityManager->getRepository(Equipement::class)->findAll();


        $form = $this->createForm(ReservationType::class, $reservation
,[
            'events' => $events,
            'locations' => $locations,
            'equipements' => $equipments,
        ]);

        $form->handleRequest($request);

        return $this->render('reservation/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/reservation', name: 'reservation_list')]
    public function list(): Response
    {
        // Récupérer les réservations de l'utilisateur connecté
        $user = $this->getUser();
        $reservations = $user ? $user->getReservation() : [];

        if($form->isSubmitted()&& $form->isValid()){
            $user = $this->getUser();
            if($user){
                $reservation->setUser($user);
            }
        }

        if ($reservation->getReservationCategory() === 'event') {
            // Si la réservation est pour un événement, on associe l'événement et on met à null le lieu et l'équipement
            $event = $form->get('event')->getData();
            $reservation->setEvent($event);
            $reservation->setLocation(null);
            $reservation->setEquipement(null);
        } elseif ($reservation->getReservationCategory() === 'location') {
            // Si la réservation est pour un lieu, on associe le lieu et met à null l'événement et l'équipement
            $location = $form->get('location')->getData();
            $reservation->setLocation($location);
            $reservation->setEvent(null);
            $reservation->setEquipement(null);
        } elseif ($reservation->getReservationCategory() === 'equipement') {
            // Si la réservation est pour un équipement, on associe l'équipement et met à null l'événement et le lieu
            $equipement = $form->get('equipement')->getData();
            $reservation->setEquipement($equipement);
            $reservation->setEvent(null);
            $reservation->setLocation(null);
        }

        $entityManager->persist($reservation);
        $entityManager->flush();

        $this->addFlash('success', 'Votre réservation a été enregistrée avec succès.');
        return $this->redirectToRoute('reservation_list');



        return $this->render('reservation/list.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
