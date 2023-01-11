<?php

namespace App\Controller;

use App\Entity\Transfert;
use App\Form\TransfertType;
use App\Repository\TransfertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function new(Request $request, TransfertRepository $transfertRepository, SluggerInterface $slugger): Response
    {
        $expediteur = $this->getUser();
        $transfert = new Transfert();
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

            $transfert->setExpediteur($expediteur);
            
           // Status du transfert à l'envoi 
            $status="Envoyé";
            $transfert->setStatut($status);

            //Date d'envoie du transfert.
            $date = new \DateTime('@' . strtotime('now'));
            $transfert->setDateEnvoi($date);

            //Code secret du transfert.
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



            $transfert->setIsVisible(true);
            $transfertRepository->save($transfert, true);
            return $this->redirectToRoute('app_transfert_index', [], Response::HTTP_SEE_OTHER);
        }



        return $this->renderForm('transfert/new.html.twig', [
            'transfert' => $transfert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transfert_show', methods: ['GET'])]
    public function show(Transfert $transfert): Response
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

        return $this->renderForm('transfert/edit.html.twig', [
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
}
