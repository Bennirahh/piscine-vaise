<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\Sector;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('UserName', TextType::class, [
            'label' => 'Nom',
            'attr' => ['class' => 'input-class'], // Ajoute ici des classes CSS si nécessaire
        ])
        ->add('UserFirstname', TextType::class, [
            'label' => 'Prénom',
            'attr' => ['class' => 'input-class'],
        ])
        ->add('email', EmailType::class, [
            'label' => 'E-mail',
            'attr' => ['class' => 'input-class'],
        ])
        ->add('UserPhone', TelType::class, [
            'label' => 'Téléphone',
            'attr' => ['class' => 'input-class'],
        ])
        ->add('UserBirthday', BirthdayType::class, [
            'label' => 'Date de naissance',
            'widget' => 'single_text',
            'attr' => ['class' => 'input-class'],
        ]);
}
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
