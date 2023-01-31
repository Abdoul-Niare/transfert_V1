<?php

namespace App\Form;

use App\Entity\User;


use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('username')
            // ->add('roles')
            // ->add('password')
            ->add('nom', TextType::class, [
                'label' => "Nom :",
                'attr' => [
                    'placeholder' => 'Nom Prenom'
            ] ])
            ->add('prenom', TextType::class, [
                'label' => "Prenom :",
                'attr' => [
                    'placeholder' => 'Prenom'
            ] ])
            ->add('mail', EmailType::class, [
                'label' => "Email :",
                'attr' => [
                    'placeholder' => 'email'
            ] ])
            ->add('valider', SubmitType::class)
            // ->add('mail')
            // ->add('ville')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
