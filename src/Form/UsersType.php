<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('UserName', TextType::class, [
                'label' => 'Nom d\'utilisateur'
            ])
            ->add('UserFirstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('UserPhone', IntegerType::class, [
                'label' => 'Numéro de téléphone'
            ])
            ->add('UserBirthday', BirthdayType::class, [
                'label' => 'Date de naissance'
            ])
            ->add('UserIsAdmin', CheckboxType::class, [
                'label' => 'Est administrateur',
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Mettre à jour le profil'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
