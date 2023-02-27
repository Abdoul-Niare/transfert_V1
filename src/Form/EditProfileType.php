<?php

namespace App\Form;

use App\Entity\User;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => "Nom identifiant",
                'attr' => [
                    'placeholder' => 'Nom identifiant'
                ]
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => "Mot de passe",
                'mapped' => false,
                'required' => false,
            ])
            ->add('nom', TextType::class, [
                'label' => "Nom",
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => "Prenom",
                'attr' => [
                    'placeholder' => 'Prenom'
                ]
            ])
            ->add('mail', EmailType::class, [
                'label' => "Email",
                'attr' => [
                    'placeholder' => 'email'
                ]
            ])
            ->add('ville');
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
