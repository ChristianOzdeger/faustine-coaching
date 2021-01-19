<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use App\Form\CompositionType;
use App\Form\IngredientType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RecetteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recette::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            IntegerField::new('temps_preparation', 'Temps de préparation (min)'),
            IntegerField::new('temps_cuisson', 'Temps de cuisson (min)'),
            IntegerField::new('nombre_personne', 'Nombre de personnes'),
            TextEditorField::new('description'),
            TextField::new('photoFile', 'Photo')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('photoName', 'Photo')
                ->setBasePath('uploads/photos/recettes')
                ->onlyOnIndex(),
            AssociationField::new('categorie', 'Catégorie(s)')
                ->onlyOnForms(),
            CollectionField::new('compositions', 'Ingrédient(s)')
                ->setEntryType(CompositionType::class)
                ->allowAdd()
                ->allowDelete()
                ->onlyOnForms(),
        ];
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUtilisateur($this->getUser());
        $entityInstance->setCreatedAt(new \DateTime());
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        $entityInstance->setUpdatedAt(new \DateTime());
        parent::updateEntity($entityManager, $entityInstance);
    }

}
