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
use App\Entity\Equipement; // Correction ici
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use     EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class EquipementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Equipement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('equipementName', 'Nom');
        yield DateTimeField::new('equipementDuration', 'Durée');
        yield IntegerField::new('equipementPrice', 'Price');  // Correction du champ 'Price'
        yield ImageField::new('images', 'Image')
        ->setBasePath('uploads/images')
        ->setUploadDir('public/uploads/images')
        ->setUploadedFileNamePattern('[randomhash].[extension]')
        ->setRequired(false);
        yield TextareaField::new('description', 'Description')
        ->setHelp('help text')
        ->setFormTypeOptions([
            'attr' => ['class' => 'ckeditor'],
        ]);
    }
}

