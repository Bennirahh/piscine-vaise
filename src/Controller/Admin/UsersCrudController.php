<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Sector;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Controller\Admin;







class UsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('UserName', 'Nom');
        yield TextField::new('UserFirstname', 'Prenom');
        yield EmailField::new('email', 'Email');
        yield TelephoneField::new('UserPhone', 'Téléphone');
        yield DateField::new('UserBirthday', 'Date de naissance');
        yield BooleanField::new('UserIsAdmin', 'Admin');

        yield TextField::new('password', 'Mot de passe');
        yield AssociationField::new('sector')
        ->setLabel('Specialité')
        ->setRequired(false)
        ->setFormTypeOption('choice_label', 'sectorName'); 
    }
    
}
