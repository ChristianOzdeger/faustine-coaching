<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Repository\CategorieRepository;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/recettes", name="recette_")
     */
class RecipeController extends AbstractController
{
    /**
     * @Route("/{categorie}/{page}", name="list")
     */
    public function list(RecetteRepository $recetteRepository, CategorieRepository $categorieRepository, $categorie = "tout", $page = 1): Response
    {
            if($categorie !== 'tout'){
                $totalRecettes = $recetteRepository->CountAllRecipesWithCategory($categorie);
            }else{
                $totalRecettes = $recetteRepository->CountAllRecipes();
            }
            $totalRecettes = $totalRecettes['total'];

            $nombreRecetteAffichees = 6;
            $nombrePages = (int)ceil($totalRecettes / $nombreRecetteAffichees);
            $pagePrecedente = 1;
            $pageSuivante = $page + 1;

        
            $debutSelection = 0; 
            if($page != 1){
                $debutSelection = (($page - 1) * $nombreRecetteAffichees);
                $pagePrecedente = $page - 1;
            }

            if($page == $nombrePages){
                $pageSuivante = $page;
            } 
             
            if($categorie !== 'tout'){
                $recettes = $recetteRepository->findRecipesWithCategory($categorie, $debutSelection, $nombreRecetteAffichees);
            }else{
                $recettes = $recetteRepository->findRecipesInInterval($debutSelection, $nombreRecetteAffichees);
            }
            $categories = $categorieRepository->findAll();

        return $this->render('recipe/list.html.twig',[ 
            'recettes' => $recettes,
            'categories' => $categories,
            'nombrePages' => $nombrePages,
            'pagePrecedente' => $pagePrecedente,
            'pageSuivante' => $pageSuivante,
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="list_categorie")
     */
    /*public function listForOneCategory(RecetteRepository $recetteRepository, CategorieRepository $categorieRepository, $id): Response
    { 
            //$recettes = $recetteRepository->findRecipesWithCategory($id);
            $categories = $categorieRepository->findAll();

        
        return $this->render('recipe/list.html.twig',[ 
            'recettes' => $recettes,
            'categories' => $categories,
        ]);
    }*/

    /**
     * @Route("/detail/{slug}", name="read" , priority=2)
     */
    public function read(Recette $recette, RecetteRepository $recetteRepository): Response
    {
        $dernieresRecettes = $recetteRepository->findLastRecipes(3);

        $Recettes = $recetteRepository->findAll();

        $totalRecette = count($Recettes);
        $recettesAleatoires = [];
        $nombres = [];

        do{
            $index = rand(0,($totalRecette - 1));
            if(!in_array($index, $nombres)){
                $recettesAleatoires[] = $Recettes[$index];
                $nombres[] = $index;
            }
        }while(count($nombres)< 3);

        

        return $this->render('recipe/read.html.twig',[ 
            'recette' => $recette,
            'dernieresRecettes' => $dernieresRecettes,
            'recettesAleatoires' => $recettesAleatoires,
            
        ]);
    }
}
