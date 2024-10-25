<?php

namespace App\Controller\Admin;

use App\Entity\Sector;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SectorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sector::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('users')
        ->setLabel('Utilisateur')
        ->setRequired(true)
        ->setFormTypeOption('choice_label', 'UserFirstname'); 

        yield TextField::new('sectorName','Specialité');
    }
    
}
