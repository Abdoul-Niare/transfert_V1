<?php

namespace App\Form;

use App\Entity\Transfert;
use App\Entity\Ville;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class TransfertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ville', Null, [
                'label' => "Ville Bénéficiare:",
            ])
            ->add('nomBenef', TextType::class, [
                'label' => "Nom et Prenom de votre Bénéficiaire:",
                'attr' => [
                    'placeholder' => 'Nom et Prenom'
            ]])
            
            ->add('numTelBenef', TelType::class, [
                'label' => "Numero Tel:",

                'invalid_message' => 'Veuillez fournir un numéro de téléphone valide.',
                'attr' => [
                    'placeholder' => '+223 00 00 00 00'
            ]])

            ->add('montTransfert', NumberType::class, [
                'label' => 'Montant en euro:',
                'attr' => [
                    'placeholder' => 'Montant envoyé']
            ])

            ->add('fraisTransfert', NumberType::class, [
                'label' => "Frais en euro:",
                'attr' => [
                    'placeholder' => 'frais d\'envoi']
            ])

            ->add('montBenef', NumberType::class, [
                'label' => 'Montant en CFA:',
                'attr' => [
                    'placeholder' => 'Le bénéficiaire réçoit']
            ])
            
            ->add('numBenef', FileType::class, [
                'label' => 'Photo de la pièce',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',

                    ])
                ],
            ])
                   // ->add('comTransfert', NumberType::class, [
            //     'label' => 'adresse du transfert:',
            // ])
          
                // ->add('comTransfert', NumberType::class, [
            //     'label' => " Commission de l'appli: ",
            // ])
            // ->add('comAgentLivreur', NumberType::class, [
            //     'label' => " Commission de l'agent livreur:",
            // ])

            // ->add('agentLivreur')
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
