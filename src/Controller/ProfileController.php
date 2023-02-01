<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use App\Repository\TransfertRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, TransfertRepository $transfertRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $id = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            $this->addFlash('success', 'Profil modifié avec succès.');
            return $this->redirectToRoute('user_profile_modifier', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/index.html.twig', [
            'transferts' => $transfertRepository->findBy(
                ['agentLivreur' => $id],
            ),
            'user' => $user,
            'form' => $form->createView(),

        ]);
    }
}
