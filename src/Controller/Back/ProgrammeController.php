<?php

namespace App\Controller\Back;

use App\Entity\Affectation;
use App\Entity\Programme;
use App\Entity\User;
use App\Entity\TypeProgramme;
use App\Form\ProgrammeType;
use App\Repository\AffectationRepository;
use App\Repository\ProgrammeRepository;
use App\Repository\DetailsProgrammeRepository;
use App\Repository\UserRepository;
use App\Repository\TypeProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use DateTime;
Use DateTimeZone;

#[Route('/back/programme')]
class ProgrammeController extends AbstractController
{
    #[Route('/', name: 'app_back_programme_index', methods: ['GET'])]
public function index(ProgrammeRepository $programmeRepository, DetailsProgrammeRepository $detailsProgrammeRepository, Request $request): Response
{
    /** @var User $currentUser */
    $currentUser = $this->getUser();
    // Récupérer l'identifiant du programme à partir de la requête
    $programmeId = $request->query->get('programmeId');

    // Récupérer les détails du programme correspondant à l'identifiant
    $detailsProgramme = $detailsProgrammeRepository->findBy(['programme' => $programmeId]);

    // Récupérer tous les détails des programmes
    $detailsProgrammes = $detailsProgrammeRepository->findAll();

    // Récupérer tous les programmes
    $programmes = $programmeRepository->findAll();

    return $this->render('back/programme/index.html.twig', [
        'programmes' => $programmes,
        'details_programmes' => $detailsProgrammes,
        'details_programme' => $detailsProgramme,
        'currentUser' => $currentUser
    ]);
}

#[Route('/new', name: 'app_back_programme_new', methods: ['GET', 'POST'])]
#[IsGranted('ROLE_COACH')]
public function new(Request $request, AffectationRepository $affectationRepository, EntityManagerInterface $entityManager, UserRepository $userRepository, TypeProgrammeRepository $typeProgrammeRepository): Response
{
    /** @var User $currentUser */
 /** @var User $currentUser */
 $currentUser = $this->getUser();
 $userRep = $entityManager->getRepository(Affectation::class);
 $user = $this->getUser();
 
 $mesadh = $userRep->findBy(['coach' => $user]);

    $users = $userRepository->findBy(['tache' => 'ROLE_USER']);
    $affectations = $affectationRepository->findAll();
    $typeProgrammes = $typeProgrammeRepository->findAll();
    
    $programme = new Programme();

    $form = $this->createForm(ProgrammeType::class, $programme, [
        'users' => $users,
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Fetch the user based on form data
        $userId = $request->request->get('userId');
        $user = $userRepository->find($userId);
        $programme->setUserId($user);
        
        // Fetch the typeProgramme based on form data
        $typeProgrammeId = $request->request->get('libelle');
        $typeProgramme = $typeProgrammeRepository->find($typeProgrammeId);
        $programme->setTypeId($typeProgramme);

        // Set the start and end dates
        $dateDebut = $request->request->get('dateDebut');
        $dateFin = $request->request->get('dateFin');
        $programme->setDateDebut($dateDebut);
        $programme->setDateFin($dateFin);
        $programme->setCoach($currentUser);
        // Persist the programme entity
        $entityManager->persist($programme);
        $entityManager->flush();

        return $this->redirectToRoute('app_back_programme_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('back/programme/new.html.twig', [
        'programme' => $programme,
        'form' => $form->createView(),
        'users' => $mesadh,
        'typeProgrammes' => $typeProgrammes,
        'affectations' => $affectations,
        'currentUser' => $currentUser
    ]);
}

    
    #[Route('/{id}', name: 'app_back_programme_show', methods: ['GET'])]
    public function show(Programme $programme): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/programme/show.html.twig', [
            'programme' => $programme,
            'currentUser' => $currentUser
        ]);
    }


    #[Route('/{id}/edit', name: 'app_back_programme_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_COACH')]
    public function edit(Request $request, Programme $programme, AffectationRepository $affectationRepository, EntityManagerInterface $entityManager, UserRepository $userRepository, TypeProgrammeRepository $typeProgrammeRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $userRep = $entityManager->getRepository(Affectation::class);
        $user = $this->getUser();
        
        $mesadh = $userRep->findBy(['coach' => $user]);
    
        $users = $userRepository->findBy(['tache' => 'ROLE_USER']);
        $affectations = $affectationRepository->findAll();
        $typeProgrammes = $typeProgrammeRepository->findAll();
        
        // Create the form and populate it with the existing Programme data
        $form = $this->createForm(ProgrammeType::class, $programme, [
            'users' => $users,
        ]);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Fetch the user based on form data
            $userId = $request->request->get('userId');
            $user = $userRepository->find($userId);
            $programme->setUserId($user);
            
            // Fetch the typeProgramme based on form data
            $typeProgrammeId = $request->request->get('libelle');
            $typeProgramme = $typeProgrammeRepository->find($typeProgrammeId);
            $programme->setTypeId($typeProgramme);
    
            // Set the start and end dates
            $dateDebut = $request->request->get('dateDebut');
            $dateFin = $request->request->get('dateFin');
            $programme->setDateDebut($dateDebut);
            $programme->setDateFin($dateFin);
            $programme->setCoach($currentUser);
    
            // Persist the updated programme entity
            $entityManager->flush();
    
            return $this->redirectToRoute('app_back_programme_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('back/programme/edit.html.twig', [
            'programme' => $programme,
            'form' => $form->createView(),
            'users' => $mesadh,
            'typeProgrammes' => $typeProgrammes,
            'affectations' => $affectations,
            'currentUser' => $currentUser
        ]);
    }
    


    #[Route('/{id}', name: 'app_back_programme_delete', methods: ['POST'])]
    public function delete(Request $request, Programme $programme, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$programme->getId(), $request->request->get('_token'))) {
            $entityManager->remove($programme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_programme_index', [
            'currentUser' => $currentUser
        ], Response::HTTP_SEE_OTHER);
    }
}
