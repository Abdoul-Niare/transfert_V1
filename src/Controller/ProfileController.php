<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TransfertRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function index(TransfertRepository $transfertRepository, UserRepository $userRepository): Response
    {  
         $id = $this->getUser();
        return $this->render('profile/index.html.twig', [
            'transferts'=> $transfertRepository->findBy(
                    ['agentLivreur'=>$id],
                 
            ),
        ]);
    }
}
