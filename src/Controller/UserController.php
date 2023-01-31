<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use App\Form\UserType;
use App\Repository\TransfertRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, TransfertRepository $transfertRepository): Response
    {   
        // $id = $this->getUser();
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            // 'transferts' => $transfertRepository->findBy(
            //     ['agentLivreur' => $id],

            // ),


        ]);

       
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]

    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword('plainPassword');
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,

        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]

    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]

    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/user/profile/modifier', name: 'user_profile_modifier', methods: ['GET', 'POST'])]
    // #[IsGranted('ROLE_USER')]
    public function EditProfile(Request $request, TransfertRepository $transfertRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', 'Profil modifié avec succès.');

            $userRepository->save($user, true);

            return $this->render('user/_profile_form.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('user/_profile_form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),

        ]);
    }
}
