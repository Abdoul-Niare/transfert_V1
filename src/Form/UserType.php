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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('username', TextType::class, [
            'label' => "Identifiant :",
            'attr' => [
                'placeholder' => 'Nom d\'utilisateur'
        ] ])
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

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])




            // ->add('mail', EmailType::class, [
            //     'label' => 'Adresse Email',
            //     'attr' => [
            //         'placeholder' => 'Email'
            //     ],
            //     'constraints' => [
            //         new Email([
            //             'message' => 'L\'adresse email {{ value }} n\'est pas une adresse email valide.'
            //         ]),
            //         new NotBlank([
            //             'message' => 'Merci de renseigner une adresse email.'
            //         ]),
            //     ]
            // ])
            
            // ->add('plainPassword', RepeatedType::class, [
            //     'type' => PasswordType::class,
            //     'invalid_message' => 'Le mot de passe ne correspond pas à sa confirmation.',
            //     'first_options' => [
            //         'label' => 'Mot de passe',
            //         'help' => 'Le mot de passe doit contenir au minimum 8 caractères dont une minuscule, une majuscule, un chiffre et un caractère spécial.',
            //     ],
            //     'second_options' => [
            //         'label' => 'Confirmation du mot de passe.',
            //     ],
            //     'mapped' => false,
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Veuillez renseigner un mot de passe.',
            //         ]),
            //         new Length([
            //             'min' => 8,
            //             'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
            //             // max length allowed by Symfony for security reasons
            //             'max' => 255,
            //             'maxMessage' => 'Votre mot de passe doit contenir au maximum {{ limit }} caractères.'
            //         ]),
            //         new Regex([
            //             'pattern' => "/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ !\"\#\$%&\'\(\)*+,\-.\/:;<=>?@[\\^\]_`\{|\}~])^.{0,4096}$/",
            //             'message' => 'Le mot de passe doit contenir obligatoirement une minuscule, une majuscule, un chiffre et un caractère spécial.',
            //         ])
            //     ]
            // ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
