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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $equipements = $options['equipements'] ?? [];
        $locations = $options['locations'] ?? [];
        $events = $options['events'] ?? [];
        $user = $options['user']; // Récupère l'utilisateur passé en option.
    
        $builder
            // Champ caché pour passer l'utilisateur connecté
            ->add('user', HiddenType::class, [
                'data' => $user ? $user->getUserName() : null,
                'mapped' => false, // Non lié à une propriété de l'entité Reservation
            ])
    
            // Type de réservation
            ->add('reservationCategory', ChoiceType::class, [
                'choices' => [
                    'Event' => 'event',
                    'Location' => 'location',
                    'Equipement' => 'equipement',
                ],
                'placeholder' => 'Sélectionner un type de réservation',
                'attr' => [
                    'data-role' => 'reservation-category', // Ajout d'un data-* pour JavaScript
                ],
            ])
    
            // Date de réservation
            ->add('reservationDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de réservation',
                'required' => true,
                'attr' => [
                    'data-role' => 'reservation-date', // Ajout d'un data-* pour JavaScript
                    'class' => 'reservation-date', // Utilisation d'une classe pour identifier le champ
                ],
            ])
    
            // Affichage de la date de l'événement si sélectionné
            ->add('eventDate', HiddenType::class, [
                'mapped' => false, // Ne pas lier à une entité, juste pour afficher
                'attr' => [
                    'class' => 'event-date', // Utilisation d'une classe pour identifier le champ
                    'readonly' => 'readonly',
                ],
            ])
    
            // Nombre de personnes
            ->add('reservationPeaopleNumber', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'required' => true,
                'attr' => [
                    'data-role' => 'reservation-people-number', // Ajout d'un data-* pour JavaScript
                ],
            ])
    

    
            // Sélection d'un événement
            ->add('event', ChoiceType::class, [
                'choices' => $events,
                'choice_label' => function (Event $event) {
                    return $event->getEventName(); // Nom de l'événement
                },
                'choice_attr' => function (Event $event) {
                    return [
                        'data-price' => $event->getEventPrice(), // Prix de l'événement
                        'data-description' => $event->getDescription(), // Description (exemple supplémentaire)
                        'data-date' => $event->getEventDate()->format('Y-m-d H:i:s'), // Date de l'événement formatée
                    ];
                },
                'placeholder' => 'Sélectionner un événement',
                'required' => false,
                'attr' => [
                    'data-role' => 'event-selector', // Ajout d'un data-* pour JavaScript
                ],
            ]);
    
        // Sélection d'un lieu si disponible
        if ($locations) {
            $builder->add('location', ChoiceType::class, [
                'choices' => $locations,
                'choice_label' => function (Location $location) {
                    return $location->getLocationName(); // Nom de l'emplacement
                },
                'choice_attr' => function (Location $location) {
                    return [
                        'data-price' => $location->getLocationPrice(), // Prix de l'emplacement
                        'data-capacity' => $location->getLocationCapacity(), // Capacité du lieu
                    ];
                },
                'placeholder' => 'Sélectionner un lieu',
                'required' => false,
                'attr' => [
                    'data-role' => 'location-selector', // Ajout d'un data-* pour JavaScript
                ],
            ]);
        }
    
        // Sélection d'un équipement si disponible
        if ($equipements) {
            $builder->add('equipement', ChoiceType::class, [
                'choices' => $equipements,
                'choice_label' => function (Equipement $equipement) {
                    return $equipement->getEquipementName(); // Nom de l'équipement
                },
                'choice_attr' => function (Equipement $equipement) {
                    return [
                        'data-price' => $equipement->getEquipementPrice(), // Prix de l'équipement
                    ];
                },
                'placeholder' => 'Sélectionner un équipement',
                'required' => false,
                'attr' => [
                    'data-role' => 'equipement-selector', // Ajout d'un data-* pour JavaScript
                ],
            ]);
        }
    
        // Bouton de soumission
        $builder->add('save', SubmitType::class, [
            'label' => 'Procéder au paiement',
            'attr' => [
                'data-role' => 'submit-button', // Ajout d'un data-* pour JavaScript
            ],
        ]);
    
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'equipements' => [],
            'locations' => [],
            'events' => [],
            'user' => null, // Paramètre pour passer l'utilisateur connecté
        ]);
    }
}
