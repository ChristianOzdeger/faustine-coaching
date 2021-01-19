<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Contact;
use App\Entity\Document;
use App\Entity\Ingredient;
use App\Entity\Mesure;
use App\Entity\Recette;
use App\Entity\Sport;
use App\Entity\Theme;
use App\Entity\Unite;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(UtilisateurCrudController::class)->generateUrl());
        return parent::index();

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Faustine Coaching');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        
        
        yield MenuItem::section('Accès');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', Utilisateur::class);
        
        yield MenuItem::section('Données');
        yield MenuItem::linkToCrud('Mesures', 'fas fa-list', Mesure::class);
        yield MenuItem::linkToCrud('Documents', 'fas fa-list', Document::class);

        yield MenuItem::section('Demandes de contact');
        yield MenuItem::linkToCrud('Contacts', 'fas fa-list', Contact::class);

        yield MenuItem::section('Recettes');
        yield MenuItem::linkToCrud('Recettes', 'fas fa-list', Recette::class);
        yield MenuItem::linkToCrud('Ingrédients', 'fas fa-list', Ingredient::class);
        yield MenuItem::linkToCrud('Unités de mesure', 'fas fa-list', Unite::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Categorie::class);

        yield MenuItem::section('Sport');
        yield MenuItem::linkToCrud('Séances de sport', 'fas fa-list', Sport::class);
        yield MenuItem::linkToCrud('Thèmes', 'fas fa-list', Theme::class);

    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('assets/styles/admin.css');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            // the first argument is the "template name", which is the same as the
            // Twig path but without the `@EasyAdmin/` prefix
            ->overrideTemplate('layout', 'bundles/EasyAdminBundle/custom-layout.html.twig')
        ;
    }
}
