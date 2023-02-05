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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, TransfertRepository $transfertRepository, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository): Response
    {
        $user = new User();
        $user = $this->getUser();
        $id = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('plainPassword')->getData() != null){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }
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


    // #[Route('/profile', name: 'app_profile', methods: ['GET', 'POST'])]
    // // #[IsGranted('ROLE_USER')]
    // public function EditProfile(Request $request, UserRepository $userRepository, EntityManagerInterface $manager , UserPasswordHasherInterface $hasher): Response
    // {
    //     $user = $this->getUser();

    //     $form = $this->createForm(EditProfileType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         if($hasher->isPasswordValid($user, $form->getData()->getPlainPassword))
    //         {
    //             $user= $form->getData();
    //             $manager-> persist($user);
    //             $manager->flush();

    //             $user->save($user, true);
    //             $this->addFlash('success', 'Profil modifié avec succès.');
    //             return $this->redirectToRoute('user_profile_modifier', [], Response::HTTP_SEE_OTHER);
    //         }else
    //          {
    //             $this->addFlash('error', 'Mot de passe incorrect');
    //         }
    //     }

    //     return $this->render('user/_profile_form.html.twig', [
    //         'user' => $user,
    //         'form' => $form->createView(),

    //     ]);
    // }
}
