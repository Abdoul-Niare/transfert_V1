<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Ville;
use App\Repository\TransfertRepository;
use App\Repository\UserRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TransfertRepository $transfertRepository, VilleRepository $villeRepository): Response
    {
        //var_dump('erer');exit;
        return $this->render('main/home.html.twig', [
            'nav_activ' => "home",
            // 'controller_name' => 'MainController',
            'transferts' => $transfertRepository->findBy([
                'is_visible' => true,
                'statut' => [
                    'Pris en charge',
                    'envoyé'
                ],
            ]),
            'villes' => $villeRepository->findAll(),
            

        ]);
    }

    #[Route('/tab/{id}', name: 'tab', methods: ['GET'])]

    public function tab(Ville $ville, TransfertRepository $transfertRepository, VilleRepository $villeRepository): Response
    {
        return $this->render('main/tab.html.twig', [
            'nav_activ' => $ville->getName(),
            'vil' => $ville,
            'transferts' => $transfertRepository->findAll(),
            // 'villes' => $villeRepository->findAll(),
        ]);
    }
}
