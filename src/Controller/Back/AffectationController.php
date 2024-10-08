<?php

namespace App\Controller\Back;

use App\Entity\Affectation;
use App\Entity\User;
use App\Form\AffectationType;
use App\Repository\AffectationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/back/affectation')]
class AffectationController extends AbstractController
{
    #[Route('/', name: 'app_back_affectation_index', methods: ['GET'])]
    public function index(AffectationRepository $affectationRepository, UserRepository $userRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        // Fetch all affectations
        $affectations = $affectationRepository->findAll();
        $users = $userRepository->findAll();

        return $this->render('/back/affectation/index.html.twig', [
            'affectations' => $affectations,
            'userRepository' => $userRepository,
            'users' => $users, // Pass UserRepository to access user details
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/mesaffectations', name: 'app_back_affectation_index2', methods: ['GET'])]
    public function index2(AffectationRepository $affectationRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        

        if (!$currentUser) {
            throw new \LogicException('User not logged in.');
        }

        $affectations = $affectationRepository->findBy(['adherent' => $currentUser]);

        return $this->render('back/affectation/index2.html.twig', [
            'affectations' => $affectations,
            'currentUser' => $currentUser
        ]);
    }


    #[Route('/new', name: 'app_back_affectation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();


        $userRepository = $entityManager->getRepository(User::class);
        
        // Find users with the "coach" role
        $coachUsers = $userRepository->findBy(['tache' => 'ROLE_COACH']);
        
        // Find users with the "user" role
        $users = $userRepository->findBy(['tache' => 'ROLE_USER']);
        
        // Create a new instance of Affectation
        $affectation = new Affectation();
        
        // Create the form using AffectationType
        $form = $this->createForm(AffectationType::class, $affectation, [
            'include_statut' => false 
        ]);
        
        // Handle form submission
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the selected user and coach
            $adherentId = $request->request->get('user');
            $coachId = $request->request->get('coach');
            
            // Find the selected user and coach entities
            $adherent = $userRepository->find($adherentId);
            $coach = $userRepository->find($coachId);
            
            // Set the coach and user for the affectation
            $affectation->setCoach($coach);
            $affectation->setAdherent($adherent);

            if ($affectation->getStatut() === null) {
                $affectation->setStatut('en attente');
            }
    


            // Persist the affectation in the database
            $entityManager->persist($affectation);
            $entityManager->flush();
            
            // Remove the selected user from the list of available users
            $users = array_values(array_filter($users, function($user) use ($adherent) {
                return $user->getId() !== $adherent->getId();
            }));
            
            // Redirect to the index page after successful submission
            return $this->redirectToRoute('app_back_affectation_index2', [], Response::HTTP_SEE_OTHER);
        }
        
        // Render the form template with necessary variables
        return $this->render('/back/affectation/new.html.twig', [
            'form' => $form->createView(), // Pass the form view to the template
            'coachUsers' => $coachUsers, // Pass coach users to the template
            'users' => $users,
            'affectation' => $affectation, // Pass regular users to the template
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/mesadh', name: 'app_back_mesadh')]
    public function mesadh(EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $userRepository = $entityManager->getRepository(Affectation::class);
        $user = $this->getUser();
        
        $mesadh = $userRepository->findBy(['coach' => $user]);
    
    
        
        // Render the form template with necessary variables
        return $this->render('/back/affectation/mesadh.html.twig', [
            'mesadh' => $mesadh, // Pass coach users to the template
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_back_affectation_show', methods: ['GET'])]
    public function show(Affectation $affectation): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/affectation/show.html.twig', [
            'affectation' => $affectation,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_affectation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affectation $affectation, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $users = $userRepository->findBy(['tache' => 'ROLE_USER']);
        $coachUsers = $userRepository->findBy(['tache' => 'ROLE_COACH']);

        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             // Get the selected user and coach
             $adherentId = $request->request->get('user');
             $coachId = $request->request->get('coach');
             
             // Find the selected user and coach entities
             $adherent = $userRepository->find($adherentId);
             $coach = $userRepository->find($coachId);
             
             // Set the coach and user for the affectation
             $affectation->setCoach($coach);
             $affectation->setAdherent($adherent);

            $entityManager->flush();

            return $this->redirectToRoute('app_back_affectation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/affectation/edit.html.twig', [
            'affectation' => $affectation,
            'form' => $form->createView(), // Assurez-vous d'avoir également cette variable dans votre contrôleur
            'users' => $users,
            'coachUsers' => $coachUsers,
            'currentUser' => $currentUser
            

        ]);
    }

    #[Route('/{id}', name: 'app_back_affectation_delete', methods: ['POST'])]
    public function delete(Request $request, Affectation $affectation, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('delete' . $affectation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($affectation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_affectation_index', [
            'currentUser' => $currentUser
        ], Response::HTTP_SEE_OTHER);
    }
}
