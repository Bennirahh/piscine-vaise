<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Voulzy'
                ]
            ])
            ->add('user_firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Laurent'
                ]
            ])
            ->add('user_phone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => '0x xx xx xx xx'
                ]
            ])
            ->add('user_birthday', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => '20/01/1961'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',

                'attr' => [
                    'placeholder' => 'Exemple@exemple.fr'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',
                'attr' => [
                    'placeholder' => 'Mot de passe'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Agree to terms and conditions'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configurez vos options de formulaire ici
        ]);
    }
}
