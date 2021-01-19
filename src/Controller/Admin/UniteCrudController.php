<?php

namespace App\Controller\Admin;

use App\Entity\Unite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UniteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Unite::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle', 'Libellé'),
        ];
    }
    
}
