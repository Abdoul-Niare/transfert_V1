<?php

namespace App\Form;

use App\Entity\Transfert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransfertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('statut')
            // ->add('codeSecret')
            ->add('montTransfert')
            // ->add('montBenef')
            ->add('fraisTransfert')
            // ->add('comTransfert')
            // ->add('comAgentLivreur')
            ->add('nomBenef')
            ->add('numBenef')
            ->add('numTelBenef')
            // ->add('dateEnvoi')
            // ->add('datePrisCharge')
            // ->add('dateLivr')
            // ->add('is_visible')
            ->add('ville')
            ->add('expediteur')
            // ->add('agentLivreur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transfert::class,
        ]);
    }
}
