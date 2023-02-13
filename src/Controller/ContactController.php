<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact.index')]
    public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {   
        $contact = new Contact();
        // Le nom, le prenom et l'email seront automatiquement rempli si l'utilisateur est connecté.
        if($this->getUser()){
            $contact->setNom($this->getUser()->getNom())
                    ->setPrenom($this->getUser()->getPrenom())
                    ->setMail($this->getUser()->getMail());
        }

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();

            //Envoi de l'email
            $email = (new TemplatedEmail())
            ->from($contact->getMail())
            ->to('abdoulniare@yahoo.fr')
            ->subject($contact->getSubject())
            ->htmlTemplate('emails/contact.html.twig')
            // pass variables (name => value) to the template
            ->context([
                'contact' => $contact,    
            ]);
            $mailer->send($email);

            $this->addFlash(
                'success',
                'votre demande a été envoyé avec succès.'
            );

            return $this->redirectToRoute('contact.index');


        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }
}
