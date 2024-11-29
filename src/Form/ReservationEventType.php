<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Détails de l'événement (en lecture seule)
            ->add('event', ChoiceType::class, [
                'choices' => $options['events'], // Passer les événements à afficher
                'disabled' => true, // Désactiver les événements pour qu'ils ne puissent pas être modifiés
                'mapped' => false, // Ne pas lier le champ à l'entité Reservation
                'label' => 'Événement', 
                'choice_label' => function($event) {
                    return $event->getEventName() . ' (' . $event->getEventDate()->format('Y-m-d') . ')'; 
                },
            ])
            ->add('eventPrice', TextType::class, [
                'data' => $options['events'][0]->getEventPrice(), // Prendre le prix de l'événement
                'disabled' => true, // Désactiver ce champ pour qu'il ne soit pas modifiable
                'label' => 'Prix de l\'événement',
            ])
            ->add('eventDate', TextType::class, [
                'data' => $options['events'][0]->getEventDate()->format('Y-m-d'), // Prendre la date de l'événement
                'disabled' => true, // Désactiver ce champ pour qu'il ne soit pas modifiable
                'label' => 'Date de l\'événement',
            ])

            // Champ pour que l'utilisateur entre la date de réservation
            ->add('reservationDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de réservation'
            ])

            // Champ pour le nombre de personnes
            ->add('reservationPeaopleNumber', IntegerType::class, [
                'label' => 'Nombre de personnes'
            ])
            
            // Bouton de soumission
            ->add('submit', SubmitType::class, [
                'label' => 'Réserver'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'events' => [], // Les événements doivent être passés en paramètre
        ]);
    }
}
