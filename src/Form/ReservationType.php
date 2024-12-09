<?php 

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Event;
use App\Entity\Location;
use App\Entity\Equipement;
use App\Entity\Users;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $equipements = $options['equipements'] ?? [];
        $locations = $options['locations'] ?? [];
        $events = $options['events'] ?? [];
        $user = $options['user'];  // Cette ligne récupère l'utilisateur passé au formulaire


        $builder

        ->add('user', HiddenType::class, [
            'data' => $user ? $user->getUserName() : null,  // On passe l'ID de l'utilisateur connecté
            'mapped' => false,  // Ne pas lier ce champ à une propriété de l'entité Reservation
        ])

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
            ->add('event', ChoiceType::class, [
                'choices' => $events,
                'choice_label' => function (Event $event) {
                    return $event->getEventName(); // Le nom de l'événement
                },
                'choice_attr' => function (Event $event) {
                    return ['data-price' => $event->getEventPrice()]; // Le prix de l'événement
                },
                'placeholder' => 'Sélectionner un événement',
                'required' => false,
            ]);
            

        if ($locations) {
            $builder->add('location', ChoiceType::class, [
                'choices' => $locations,
                'choice_label' => function (Location $location) {
                    return $location->getLocationName();
                },
                'choice_attr' => function (Location $location) {
                    return ['data-price' => $location->getLocationPrice()];
                },
                'placeholder' => 'Sélectionner un lieu',
                'required' => false,
            ]);
        }

        if ($equipements) {
            $builder->add('equipement', ChoiceType::class, [
                'choices' => $equipements,
                'choice_label' => function (Equipement $equipement) {
                    return $equipement->getEquipementName();
                },
                'choice_attr' => function (Equipement $equipement) {
                    return ['data-price' => $equipement->getEquipementPrice()];
                },
                'placeholder' => 'Sélectionner un équipement',
                'required' => false,
            ]);
        }

        $builder->add('save', SubmitType::class, ['label' => 'Réserver']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'equipements' => [],
            'locations' => [],
            'events' => [],
            'user' => null, // Ajoutez ici un paramètre 'user'

        ]);
    }
}
