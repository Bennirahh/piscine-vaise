<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Reservation;
use App\Entity\Location;
use App\Entity\Equipement;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;



class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('users')
        ->setLabel('Utilisateur')
        ->setRequired(true)
        ->setFormTypeOption('choice_label', 'UserFirstname'); 

        yield AssociationField::new('event')
        ->setLabel('Evenement')
        ->setRequired(false)
        ->setFormTypeOption('choice_label', 'eventName'); 
        
        yield AssociationField::new('location')
        ->setLabel('Lieu')
        ->setRequired(false)
        ->setFormTypeOption('choice_label', 'locationName'); 

        yield AssociationField::new('equipement')
        ->setLabel('Equipement')
        ->setRequired(false)
        ->setFormTypeOption('choice_label', 'equipementName'); 


        
    
    yield TextField::new('reservationCategory','Category');

  yield IntegerField::new('reservationPeaopleNumber', 'Nombre de personnes')
    ->setRequired(true)
    ->setHelp('Indiquez le nombre de personnes pour la réservation.');

    yield IntegerField::new('reservationPrice', 'Prix')
    ->setRequired(true)
    ->setHelp('Indiquez le nombre prix de la reservation');

    
    yield DateTimeField::new('reservationDate', 'Date de réservation')
    ->setFormat('dd-MM-yyyy HH:mm:ss') 
    ->setRequired(true) // Rendre le champ requis
    ->setHelp('Sélectionnez la date et l\'heure de la réservation.'); 
}

    

    
}
