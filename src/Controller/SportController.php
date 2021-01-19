<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Repository\SportRepository;
use App\Repository\ThemeRepository;
use MediaEmbed\MediaEmbed;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sports", name="sport_")
 */
class SportController extends AbstractController
{
    /**
     * @Route("/{theme}/{page}", name="list", methods={"GET"})
     */
    public function list(SportRepository $sportRepository, ThemeRepository $themeRepository, $theme = 'tout', $page = 1): Response
    {
        if ($theme !== 'tout') {
            $totalSports = $sportRepository->CountAllSportsWithThemes($theme);
        } else {
            $totalSports = $sportRepository->CountAllSports();
        }
        $totalSports = $totalSports['total'];

        $nombreSportsAffichees = 6;
        $nombrePages = (int)ceil($totalSports / $nombreSportsAffichees);
        $pagePrecedente = 1;
        $pageSuivante = $page + 1;

        
        $debutSelection = 0;
        if ($page != 1) {
            $debutSelection = (($page - 1) * $nombreSportsAffichees);
            $pagePrecedente = $page - 1;
        }

        if ($page == $nombrePages) {
            $pageSuivante = $page;
        }
             
        if ($theme !== 'tout') {
            $sports = $sportRepository->findSportsWithThemes($theme, $debutSelection, $nombreSportsAffichees);
        } else {
            $sports = $sportRepository->findSportsInInterval($debutSelection, $nombreSportsAffichees);
        }

        $themes = $themeRepository->findAll();

        return $this->render('sport/list.html.twig', [
            'sports' => $sports,
            'themes' => $themes,
            'nombrePages' => $nombrePages,
            'pagePrecedente' => $pagePrecedente,
            'pageSuivante' => $pageSuivante,
        ]);
    }

    /**
     * @Route("/detail/{slug}", name="read", priority=2)
     */
    public function read(Sport $sport, SportRepository $sportRepository): Response
    {
        $lienYoutube = $sport->getLienYoutube();

        $derniersSports = $sportRepository->findLastSports(3);

        $Sport = $sportRepository->findAll();

        $totalSport = count($Sport);
        $sportsAleatoires = [];
        $nombres = [];

        do {
            $index = rand(0, ($totalSport - 1));
            if (!in_array($index, $nombres)) {
                $sportsAleatoires[] = $Sport[$index];
                $nombres[] = $index;
            }
        } while (count($nombres) < 3);

        if (!isset($this->MediaEmbed)) {
            $this->MediaEmbed = new MediaEmbed();
        }

        $MediaObject = $this->MediaEmbed->parseUrl($lienYoutube);

        if ($MediaObject) {
            $MediaObject->setParam([
                'autoplay' => 1,
                'loop' => 1,
                'rel' => 0,
            ]);
            $MediaObject->setAttribute([
                'type' => null,
                'class' => 'embed-responsive-item',
                'data-html5-parameter' => true
            ]);
            $MediaObject->getEmbedCode();
        }
        
        return $this->render('sport/read.html.twig', [
            'sport' => $sport,
            'derniersSports' => $derniersSports,
            'sportsAleatoires' => $sportsAleatoires,
            'MediaObject' => $MediaObject,
        ]);
    }
}
