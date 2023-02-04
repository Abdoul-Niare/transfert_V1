<?php

namespace App\Form;

use App\Entity\Transfert;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Ville;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ConfirmTransfertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nomBenef', TextType::class, [
                'label' => "Bénéficiaire :",
            ])
            ->add('numBenef', HiddenType::class, [
                'data' => '',
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label' => "Quelle destination ?",
                'attr' => ['readonly' => true],
            ])
            ->add('numTelBenef', TelType::class, [
                'label' => "Tél bénéficiaire :",
                'attr' => ['readonly' => true],
            ])
            ->add('montTransfert', NumberType::class, [
                'label' => 'Montant du transfert:',
                'attr' => ['readonly' => true],
            ])
            ->add('fraisTransfert', NumberType::class, [
                'label' => "Frais d'envoi du Transfert:",
                'attr' => ['readonly' => true],
            ])
            ->add('montBenef', NumberType::class, [
                'label' => 'Le bénéficiaire recevra:',
                'attr' => ['readonly' => true],
            ])
            ->add('comTransfert',HiddenType::class, [
                'data' => '',
            ])
            ->add('comAgentLivreur',HiddenType::class, [
                'data' => '',
            ])
            ->add('validate', SubmitType::class, ['label' => 'Valider'])
            // ->add('is_visible')
             // ->add('comTransfert')
            // ->add('numTelBenef')
            // ->add('comAgentLivreur')
            // ->add('expediteur')
            // ->add('numBenef')
            // ->add('ville')
            // ->add('dateEnvoi')
            // ->add('datePrisCharge')
            // ->add('dateLivr')
            // ->add('codeSecret')
            // ->add('statut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transfert::class,
        ]);
    }
}
