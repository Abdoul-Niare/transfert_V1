<?php

namespace App\Controller;

use App\Entity\Transfert;
use App\Form\TransfertType;
use App\Repository\TransfertRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/transfert')]
class TransfertController extends AbstractController
{
    #[Route('/', name: 'app_transfert_index', methods: ['GET'])]
    public function index(TransfertRepository $transfertRepository): Response
    {
        return $this->render('transfert/index.html.twig', [
            'transferts' => $transfertRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_transfert_new', methods: ['GET', 'POST'])]
    // #[IsGranted('ROLE_USER')]
    public function new(Request $request, TransfertRepository $transfertRepository, SluggerInterface $slugger): Response
    {
        // Gestion de l'expéditeur.
        $expediteur = $this->getUser();
        $transfert = new Transfert();
        $transfert->setExpediteur($expediteur);
        $form = $this->createForm(TransfertType::class, $transfert);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $numBenef = $form->get('numBenef')->getData();

            if ($numBenef) {
                $originalFilename = pathinfo($numBenef->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $numBenef->guessExtension();
                try {
                    $numBenef->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $transfert->setNumBenef($newFilename);
            }

            // Status du transfert à l'envoi 
            $status = "Envoyé";
            $transfert->setStatut($status);

            //Date d'envoie du transfert.
            $date = new \DateTime('@' . strtotime('now'));
            $transfert->setDateEnvoi($date);

            //Gestion du code secret du transfert.
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
            $nombre = mt_rand(1000, 9999);

            $codeSecret = $lettre . $nombre;
            $transfert->setCodeSecret($codeSecret);


            // Visibilité du transfert
            $transfert->setIsVisible(true);

            //Gestion commission
            $fraisTransfert =  $form->get('fraisTransfert')->getData();
            $comAgent = $fraisTransfert * 0.70;
            $comSite = $fraisTransfert - $comAgent;

            $transfert->setComAgentLivreur($comAgent);
            $transfert->setComTransfert($comSite);
            $transfertRepository->save($transfert, true);

            return $this->redirectToRoute('app_transfert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transfert/new.html.twig', [
            'transfert' => $transfert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transfert_show', methods: ['GET'])]
    public function show(ManagerRegistry $doctrine, Transfert $transfert): Response
    {
        return $this->render('transfert/show.html.twig', [
            'transfert' => $transfert,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transfert_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transfert $transfert, TransfertRepository $transfertRepository): Response
    {
        $form = $this->createForm(TransfertType::class, $transfert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transfertRepository->save($transfert, true);
            return $this->redirectToRoute('app_transfert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transfert/edit.html.twig', [
            'transfert' => $transfert,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_transfert_delete', methods: ['POST'])]
    public function delete(Request $request, Transfert $transfert, TransfertRepository $transfertRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $transfert->getId(), $request->request->get('_token'))) {
            $transfertRepository->remove($transfert, true);
        }

        return $this->redirectToRoute('app_transfert_index', [], Response::HTTP_SEE_OTHER);
    }


    // //dans le controller
    // #[Route('/{id}', name: 'app_transfert_take', methods: ['POST'])]
    // public function prendre_en_charge(Request $request, Transfert $transfert, TransfertRepository $transfertRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('take' . $transfert->getId(), $request->request->get('_token'))) {
    //         $agentLivreur = $this->getUser();
    //         $transfert->setAgentLivreur($agentLivreur);

    //         $transfert->setDatePrisCharge(new \DateTime('@' . strtotime('now')));
    //         $transfertRepository->save($transfert, true);
    //     }
    //     return $this->redirectToRoute('app_transfert_index', [], Response::HTTP_SEE_OTHER);

    //     return $this->render('prisEnCharge/confirm.html.twig', [
    //         'transfert' => $transfert
            
    //     ]);
    // }


    #[Route('/{id}/prendre_en_charge', name: 'app_transfert_take', methods: ['GET', 'POST'])]
    public function PrisEnCharge(Request $request, Transfert $transfert, TransfertRepository $transfertRepository): Response
    {
        $agentLivreur = $this->getUser();
        $transfert->setAgentLivreur($agentLivreur);
        $form = $this->createForm(TransfertType::class, $transfert);
        $form->handleRequest($request);
        if ($this->isCsrfTokenValid('take' . $transfert->getId(), $request->request->get('_token')))  {
            $transfert->setDatePrisCharge(new \DateTime('@' . strtotime('now')));
            // Status du transfert à l'envoi 
            $status = "Pris en charge";
            $transfert->setStatut($status);
            $transfertRepository->save($transfert, true);
            return $this->redirectToRoute('app_transfert_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('prisEnCharge/confirm.html.twig', [
            'transfert' => $transfert,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/livraison', name: 'app_transfert_delivery', methods: ['GET', 'POST'])]
    public function livrer(Request $request, Transfert $transfert, TransfertRepository $transfertRepository): Response
    {
        $agentLivreur = $this->getUser();
        $transfert->setAgentLivreur($agentLivreur);
        $form = $this->createForm(TransfertType::class, $transfert);
        $form->handleRequest($request);
        if ($this->isCsrfTokenValid('take' . $transfert->getId(), $request->request->get('_token'))) {
            $transfert->setDateLivr(new \DateTime('@' . strtotime('now')));
            // Status du transfert à l'envoi 
            $status = "livré";
            $transfert->setStatut($status);
            $transfertRepository->save($transfert, true);
            return $this->redirectToRoute('app_transfert_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('livraison/confirm.html.twig', [
            'transfert' => $transfert,
            'form' => $form,
        ]);
    }
}
