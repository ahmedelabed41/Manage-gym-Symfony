<?php

namespace App\Controller\Back;

use App\Entity\Abonnements;
use App\Entity\User;
use App\Form\AbonnementsType;
use App\Form\UserType;
use App\Repository\AbonnementsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use DateTime;
Use DateTimeZone;




#[Route('/back/abonnements')]
class AbonnementsController extends AbstractController
{



    
    #[Route('/', name: 'app_back_abonnements_index', methods: ['GET'])]
    public function index(AbonnementsRepository $abonnementsRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/abonnements/index.html.twig', [
            'abonnements' => $abonnementsRepository->findAll(),
            'currentUser' => $currentUser
        ]);
    }


    #[Route('/mesabonnements', name: 'app_back_abonnements_index2', methods: ['GET'])]
    public function index2(AbonnementsRepository $abonnementsRepository): Response
    {
        $currentUser = $this->getUser();

        if (!$currentUser) {
            throw new \LogicException('User not logged in.');
        }

        $abonnements = $abonnementsRepository->findBy(['user' => $currentUser]);

        return $this->render('back/abonnements/index2.html.twig', [
            'abonnements' => $abonnements,
            'currentUser' => $currentUser
        ]);
    }

    

    #[Route('/new', name: 'app_back_abonnements_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, UserRepository $userRepository): Response
{    
    /** @var User $currentUser */
    $currentUser = $this->getUser();

    $users = $userRepository->findBy(['tache' => 'ROLE_USER']);

    // Ajoutez une vérification pour s'assurer que l'utilisateur est bien de type User
    if (!$currentUser instanceof User) {
        throw new \LogicException('The current user is not of type User.');
    }

    $abonnements = new Abonnements();
    $form = $this->createForm(AbonnementsType::class, $abonnements, [
        'include_statut' => false 
    ]);    
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $adherent = $userRepository->find($currentUser);
        // Set the user for the abonnements
        $abonnements->setUser($adherent);
        
        // Set the start and end dates
        $dateDebut = $request->request->get('dateDebut');
        $dateFin = $request->request->get('dateFin');
        $abonnements->setDateDebut($dateDebut);
        $abonnements->setDateFin($dateFin);

        if ($abonnements->getStatut() === null) {
            $abonnements->setStatut('en attente');
        }

        // Save the abonnements
        $entityManager->persist($abonnements);
        $entityManager->flush();

        // Send the email
        $email = (new Email())
            ->from($currentUser->getEmail()) 
            ->to('adamzoghlami25@gmail.com')
            ->subject('New Subscription Created')
            ->text('Salut, je suis nommé '.$currentUser->getNom().' '.$currentUser->getPrenom().' j\'ai passé un abonnment dans votre salle et j\'attends votre confirmation. Merci');

        $mailer->send($email);

        return $this->redirectToRoute('app_back_abonnements_index2', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('back/abonnements/new.html.twig', [
        'abonnements' => $abonnements,
        'form' => $form->createView(),
        'currentUser' => $currentUser,
        'users' => $users
    ]);
}



    #[Route('/{id}', name: 'app_back_abonnements_show', methods: ['GET'])]
    public function show(Abonnements $abonnement): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/abonnements/show.html.twig', [
            'abonnement' => $abonnement,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_abonnements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Abonnements $abonnements, AbonnementsRepository $abonnementsRepository, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        // Récupérez la liste des utilisateurs depuis la base de données
        $userRepository = $entityManager->getRepository(User::class);
        
        // Find users with the "user" role
        $users = $userRepository->findBy(['tache' => 'ROLE_USER']);
        //$abonnements = $abonnementsRepository->findAll();

        // Créez votre formulaire avec les données de l'entité
        $form = $this->createForm(AbonnementsType::class, $abonnements);

        // Traitez le formulaire si nécessaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Traitez les données du formulaire et sauvegardez
            //$entityManager = $this->getDoctrine()->getManager();
            //$abonnements->setDateDebut($dateDebut);
            //$abonnements->setDateFin($dateFin);
            $entityManager->persist($abonnements);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_abonnements_index');
        }

        // Rendez le template avec le formulaire et la liste des utilisateurs
        return $this->render('back/abonnements/edit.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
            'abonnements' => $abonnements,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_back_abonnements_delete', methods: ['POST'])]
    public function delete(Request $request, Abonnements $abonnement, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$abonnement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($abonnement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_abonnements_index', [
            'currentUser' => $currentUser
        ], Response::HTTP_SEE_OTHER);
    }
}







