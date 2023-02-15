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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/user')]
#[IsGranted('ROLE_ADMIN')]
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

    public function new(Request $request, UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tmp_password = $this->generatePassword();
            $user->setPassword($userPasswordHasher->hashPassword($user,$tmp_password));
            $userRepository->save($user, true);
            
            if ($this->sendPasswordTo($mailer,$user->getMail(),$tmp_password)){
                $this->addFlash('success','Compte utilisateur créer avec succès.');
            }
            else{
                $this->addFlash("error", "Une erreur s'est produite lors de l'envoie du mot de passe");
            }
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

    public function edit(Request $request, User $user, UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->add('reset_password', SubmitType::class, ['label' => 'Réinitialiser Mot de passe']);
        $form->handleRequest($request);

        if($form->getClickedButton() && 'reset_password' === $form->getClickedButton()->getName()){
          
            $tmp_password =  $this->generatePassword();
            //Envoi mot de passe par mail
           
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $tmp_password
                )
            );
            $userRepository->save($user, true);
            if ($this->sendPasswordTo($mailer,$user->getMail(),$tmp_password)){
                $this->addFlash('success', 'Le mot de passe a été réinitialisé.');
            }
            else{
                $this->addFlash("error", "Une erreur s'est produite lors de l'envoie du mot de passe");
            }
        }
        else{
        if ($form->isSubmitted() && $form->isValid()) {
                $userRepository->save($user, true);

                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            }
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

    #[Route('/profile/modifier', name: 'user_profile_modifier', methods: ['GET', 'POST'])]
    // #[IsGranted('ROLE_USER')]
    public function EditProfile(Request $request, TransfertRepository $transfertRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {

            

        //     $userRepository->save($user, true);
        //     $this->addFlash('success', 'Profil modifié avec succès.');
        //     return $this->redirectToRoute('user_profile_modifier', [], Response::HTTP_SEE_OTHER);
        // }

        return $this->render('user/_profile_form.html.twig', [
            'user' => $user,
            'transferts'=>$transfertRepository->findAll(),
            'form' => $form->createView(),

        ]);
    }

    #[Route('/{id}', name: 'app_user_reset_password', methods: ['GET'])]
    public function resetPassword(User $user): Response
    {
        var_dump($user);
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    private function generatePassword(): string
    {
         //Generation auto mot de passe
            // Tableau de lettre en majuscule
            $lettres = range('A', 'Z');
            // Je melange
            shuffle($lettres);
            // J"extrait le premier item du tableau
            $lettre = array_shift($lettres);
            // Je recommence pour la seconde lettre
            shuffle($lettres);
            // J'extrait la seconde lettre
            $lettre .= array_shift($lettres);
            // un nombre sur 4 digitau hazard
            $nombre = mt_rand(10000, 99999);
            $tmp_password = $lettre . $nombre;
            return $tmp_password;
    }

    private function sendPasswordTo($mailer,$mail,$password) : bool
    {
        try{
        //Envoi de l'email
        $email = (new Email())
        ->from("abdoulniare@yahoo.fr")
        ->to($mail)
        ->subject("Send€CFA : Réinitialisation de votre mot de passe")
        ->html('Votre nouveau mot de passe est : '.$password);
        $mailer->send($email);
        return true;
        } catch (TransportExceptionInterface $e) {
           return false;
        }
        
    }
}
