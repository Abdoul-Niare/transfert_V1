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
    public function index(TransfertRepository $transfertRepository, VilleRepository $villeRepository, UserRepository $userRepository): Response
    {
        //var_dump('erer');exit;
        return $this->render('main/home.html.twig', [
            'nav_activ' => "home",
            'transferts' => $transfertRepository->findBy([
                'is_visible' => true,
                'statut' => [
                    'Pris en charge',
                    'envoyé'
                ],
            ]),
            'villes' => $villeRepository->findAll(),
            'users' =>$userRepository->findAll(),
            

        ]);

        return $this->render('main/home.html.twig', [
            'nav_activ' => "home"
        ]);

    }

    #[Route('/tab/{id}', name: 'tab', methods: ['GET'])]

    public function tab(Ville $ville, TransfertRepository $transfertRepository, VilleRepository $villeRepository, UserRepository $userRepository): Response
    {
        return $this->render('main/tab.html.twig', [
            'nav_activ' => $ville->getName(),
            'vil' => $ville,
            'transferts' => $transfertRepository->findAll(),
            'villes' => $villeRepository->findAll(),
            'users' =>$userRepository->findAll(),
        ]);
    }
}
