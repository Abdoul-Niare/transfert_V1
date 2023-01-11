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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class TransfertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('nomBenef', TextType:: class ,[
                    'label' => "Nom et Prenom de votre Bénéficiaire",
                ])
                ->add('numTelBenef', TelType:: class ,[ 
                    'label' => "Numero de telephone du Bénéficiaire",
                   
                    'invalid_message' => 'Veuillez fournir un numéro de téléphone valide.',
                   
                ])
        
            ->add('ville', Null, [
                
                'label' => "Ville de votre Bénéficiare",
            ])

            ->add('montTransfert', NumberType:: class ,[
                'label' => 'Montant du transfert',
            ])

            ->add('montBenef', NumberType:: class ,[
                'label' => 'Montant du Béneficiaire',
            ])

                     
            ->add('fraisTransfert', NumberType:: class ,[
                'label' => "Frais d'envoi du Transfert",
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

            ->add('comTransfert')
            // ->add('numTelBenef')
            ->add('comAgentLivreur')
        
            ->add('agentLivreur')
           
            // ->add('expediteur')
            // ->add('numBenef')
            // ->add('ville')
            // ->add('dateEnvoi')
            // ->add('datePrisCharge')
            // ->add('dateLivr')
            // ->add('is_visible')
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
