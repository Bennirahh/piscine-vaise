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
use Symfony\Component\Form\FormBuilder;


class ReservationController extends AbstractController
{
    #[Route('/reservation/new', name: 'app_reservation')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
      
        $reservation = new Reservation();

        $events = $entityManager->getRepository(Event::class)->findAll();
        $locations = $entityManager->getRepository(Location::class)->findAll();
        $equipments = $entityManager->getRepository(Equipement::class)->findAll();


        $form = $this->createForm(ReservationType::class, $reservation, [
            'events' => $entityManager->getRepository(Event::class)->findAll(),
            'locations' => $entityManager->getRepository(Location::class)->findAll(),
            'equipements' => $entityManager->getRepository(Equipement::class)->findAll(),
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $data = $form->getData();

            if ($data->getReservationCategory() === 'event' && $data->getEvent()) {
                $reservation->setReservationPrice($data->getEvent()->getPrice());
            } elseif ($data->getReservationCategory() === 'location' && $data->getLocation()) {
                $reservation->setReservationPrice($data->getLocation()->getPrice());
            } elseif ($data->getReservationCategory() === 'equipement' && $data->getEquipement()) {
                $reservation->setReservationPrice($data->getEquipement()->getPrice());
            }
        
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
    
        // Si vous souhaitez afficher un formulaire pour effectuer une nouvelle réservation ici :
        $reservation = new Reservation();
    
        // Créez un formulaire basé sur votre type de formulaire existant
        $form = $this->createForm(ReservationType::class, $reservation);
    
        // Traitez la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Associez l'utilisateur à la réservation
            if ($user) {
                $reservation->setUser($user);
            }
    
            // Gestion de la catégorie de réservation
            $category = $reservation->getReservationCategory();
            if ($category === 'event') {
                $event = $form->get('event')->getData();
                $reservation->getEventName($event);
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
    
            // Ajoutez un message flash et redirigez
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
