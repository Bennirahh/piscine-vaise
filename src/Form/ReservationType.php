<?php 

namespace App\Form;


use App\Entity\Reservation;
use App\Entity\Event;
use App\Entity\Location;
use App\Entity\Equipement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $equipements = $options['equipements'] ?? [];
        $locations = $options['locations'] ?? [];
        $events = $options['events'] ?? [];

        $builder
            ->add('reservationCategory', ChoiceType::class, [
                'choices' => [
                    'Event' => 'event',
                    'Location' => 'location',
                    'Equipement' => 'equipement',
                ],
                'placeholder' => 'Sélectionner un type de réservation',
            ])
            ->add('reservationDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de réservation',
                'required' => true,
            ])
            ->add('reservationPeaopleNumber', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'required' => true,
            ])
            ->add('reservationPrice', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR',
                'required' => true,
            ])
            // Ajoutez ici le champ 'event' en utilisant les événements passés dans les options
            ->add('event', ChoiceType::class, [
                'choices' => $events,
                'choice_label' => function (Event $event) {
                    return $event->getEventName(); // Nom de l'événement
                },
                'choice_attr' => function (Event $event) {
                    return ['data-price' => $event->getEventPrice()]; // Ajouter le prix dans l'attribut data-price
                },
                'placeholder' => 'Sélectionner un événement',
                'required' => false,
            ]);
            
        ;

        // Ajouter un champ pour les lieux si la réservation concerne un lieu
        if ($locations) {
            $builder->add('location', ChoiceType::class, [
                'choices' => $locations,
                'placeholder' => 'Sélectionner un lieu',
                'required' => false,
            ]);
        }

        // Ajouter un champ pour les équipements si la réservation concerne un équipement
        if ($equipements) {
            $builder->add('equipement', ChoiceType::class, [
                'choices' => $equipements,
                'placeholder' => 'Sélectionner un équipement',
                'required' => false,
            ]);
        }

        // Bouton de soumission
        $builder->add('save', SubmitType::class, ['label' => 'Réserver']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'equipements' => [],
            'locations' => [],
            'events' => [],
        ]);
    }
}
