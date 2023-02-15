<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('username', TextType::class, [
            'label' => "Identifiant :",
            'attr' => [
                'placeholder' => 'Nom d\'utilisateur'
            ]])
            ->add('roles', ChoiceType::class, [
                'required' => true,
                'multiple' => true,
                'expanded' => false,
                'choices'  => [
                  'User' => 'ROLE_USER',
                  'Agent' => 'ROLE_PARTNER',
                  'Admin' => 'ROLE_ADMIN',
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => "Nom :",
                'attr' => [
                    'placeholder' => 'Nom Prenom'
            ] ])
            ->add('Prenom', TextType::class, [
                'label' => "Prenom :",
                'attr' => [
                    'placeholder' => 'Prenom'
            ] ])

            ->add('ville', Null, [
                'label' => "Ville de votre Bénéficiare:",
            ])
           
            ->add('mail', TextType::class, [
                'label' => 'Adresse mail:',
                'attr' => [
                    'placeholder' => 'Email'
            ] ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
