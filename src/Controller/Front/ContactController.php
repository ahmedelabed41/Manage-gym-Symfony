<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(): Response
    {
        $currentUser = $this->getUser();
        return $this->render('front/contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/contact/send', name: 'contact_send', methods: ['POST'])]
    public function sendContactEmail(Request $request, MailerInterface $mailer): Response
    {
         /** @var User $currentUser */
         $currentUser = $this->getUser();
        // Récupération des données du formulaire
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $commentaires = $request->request->get('commentaires');

        // Validation simple
        if (empty($nom) || empty($prenom) || empty($email) || empty($commentaires)) {
            return $this->json(['status' => 'error', 'message' => 'Tous les champs sont requis.'], 400);
        }

        // Création du message email
        $message = (new Email())
            ->from('adamzoghlami25@gmail.com')
            ->to($email)
            ->subject('Nouveau message de contact')
            ->html("
                <p><strong>Nom:</strong> $nom</p>
                <p><strong>Prénom:</strong> $prenom</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Commentaires:</strong></p>
                <p>$commentaires</p>
            ");

        // Envoi de l'email
        $mailer->send($message);
        
        return $this->render('front/contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'currentUser' => $currentUser
        ]);
    }
}
