<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

use App\Entity\Users;
use App\Entity\Sector;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureFields(string $pageName): iterable
    {
      yield TextField::new('locationName', 'Nom');
        yield IntegerField::new('locationCapacity', 'Capacity');
        yield IntegerField::new('locationPrice', 'Price');
        //yield DateField::new('eventDate', 'Date de evenement');
        yield ImageField::new('image', 'Image')
        ->setBasePath('uploads/images') // Affiche les images dans 'public/uploads/images'
        ->setUploadDir('public/uploads/images') //
        ->setUploadedFileNamePattern('[randomhash].[extension]')
        ->setRequired(false);
        yield TextareaField::new('description', 'Description')
        ->setHelp('help text')
        ->setFormTypeOptions([
            'attr' => ['class' => 'ckeditor'], // Active CKEditor si vous l'avez installé
        ]);

       
    }
    
    
    
}
