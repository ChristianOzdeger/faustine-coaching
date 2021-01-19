<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
            TextField::new('nom'),
            TextField::new('prenom', 'Prénom'),
            TextField::new('plainPassword', 'Mot de passe')->onlyWhenUpdating(),
            TextField::new('password', 'Mot de passe')->onlyWhenCreating(),
            TelephoneField::new('telephone', 'Téléphone'),
        ];
    }
    
}
