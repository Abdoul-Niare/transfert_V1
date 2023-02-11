<?php

namespace App\Controller\Admin;

use App\Entity\Transfert;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class TransfertCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transfert::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */

    public function configureFilters(Filters $filters): Filters 
        
    {
        return $filters
          ->add(EntityFilter::new('transfert'))
        ;
    }
}
