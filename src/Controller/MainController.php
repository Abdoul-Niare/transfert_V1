<?php

namespace App\Controller;

use App\Repository\TransfertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TransfertRepository $transfertRepository): Response
    {
        return $this->render('main/home.html.twig', [
            'controller_name' => 'MainController',
            'transferts'=> $transfertRepository->findBy([
                'is_visible'=>true
            ])
        ]);
    }

    
}

