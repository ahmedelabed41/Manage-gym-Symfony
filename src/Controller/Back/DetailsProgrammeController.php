<?php

namespace App\Controller\Back;

use App\Entity\DetailsProgramme;
use App\Form\DetailsProgrammeType;
use App\Repository\DetailsProgrammeRepository;
use App\Repository\ExerciceRepository;
use App\Repository\ProgrammeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;
Use DateTimeZone;

#[Route('/back/details/programme')]
class DetailsProgrammeController extends AbstractController
{
    #[Route('/', name: 'app_back_details_programme_index', methods: ['GET'])]
    public function index(
        DetailsProgrammeRepository $detailsProgrammeRepository, 
        ExerciceRepository $exerciceRepository, 
        ProgrammeRepository $programmeRepository,
        Request $request
    ): Response {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $userId = $request->query->get('userId');
        $programmeId = $request->query->get('programmeId');
    
        if ($programmeId !== null) {
            // Fetch details of the specified programme
            $detailsProgramme = $detailsProgrammeRepository->findBy(['programme' => $programmeId]);
            $exercices = $exerciceRepository->findAll();
    
            return $this->render('back/details_programme/index.html.twig', [
                'details_programmes' => $detailsProgramme,
                'exercices' => $exercices,
                'programmeId' => $programmeId,
                'currentUser' => $currentUser
            ]);
        } elseif ($userId !== null) {
            // Find programmes associated with the user (coach)
            $programmes = $programmeRepository->findBy(['userId' => $userId]);
    
            if (!empty($programmes)) {
                // Assume you want the details of the first programme found
                $programmeId = $programmes[0]->getId();
    
                // Find the details of the programme
                $detailsProgramme = $detailsProgrammeRepository->findBy(['programme' => $programmeId]);
                $exercices = $exerciceRepository->findAll();
    
                return $this->render('back/details_programme/index.html.twig', [
                    'details_programmes' => $detailsProgramme,
                    'exercices' => $exercices,
                    'programmeId' => $programmeId,
                    'currentUser' => $currentUser
                ]);
            } else {
                // Handle the case where no programmes are found for the user
                return $this->render('back/details_programme/index.html.twig', [
                    'details_programmes' => [],
                    'exercices' => [],
                    'programmeId' => null,
                    'currentUser' => $currentUser,
                    'error' => 'No programmes found for the specified user.'
                ]);
            }
        } else {
            // Handle the case where neither programmeId nor userId is provided
            return $this->render('back/details_programme/index.html.twig', [
                'details_programmes' => [],
                'exercices' => [],
                'programmeId' => null,
                'currentUser' => $currentUser,
                'error' => 'No programme or user ID provided.'
            ]);
        }
    }



   



    #[Route('/new/{id}', name: 'app_back_details_programme_new', methods: ['GET', 'POST'])]
public function new($id, Request $request, ExerciceRepository $exerciceRepository, ProgrammeRepository $programmeRepository, EntityManagerInterface $entityManager): Response
{
    /** @var User $currentUser */
    $currentUser = $this->getUser();
    $exercices = $exerciceRepository->findAll();
    $programmes = $programmeRepository->findAll();

    $detailsProgramme = new DetailsProgramme();

    $form = $this->createForm(DetailsProgrammeType::class, $detailsProgramme);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $exerciceId = $request->request->get('id1');
        $exercice = $exerciceRepository->find($exerciceId);
        
        $programme = $programmeRepository->find($id);
        
        $date = $request->request->get('date');
        
        $detailsProgramme->setExercice($exercice);
        $detailsProgramme->setProgramme($programme);
        $detailsProgramme->setDate($date);
        $currentDateTime = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $formattedDateTime = $currentDateTime->format('Y-m-d');

        $entityManager->persist($detailsProgramme);
        $entityManager->flush();

        return $this->redirectToRoute('app_back_details_programme_index', [
            'programmeId' => $id,
        ], Response::HTTP_SEE_OTHER);
    }

    return $this->render('back/details_programme/new.html.twig', [
        'details_programme' => $detailsProgramme,
        'form' => $form->createView(),
        'exercices' => $exercices,
        'programmes' => $programmes,
        'currentUser' => $currentUser,
    ]);
}


    #[Route('/{id}', name: 'app_back_details_programme_show', methods: ['GET'])]
    public function show(DetailsProgramme $detailsProgramme): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/details_programme/show.html.twig', [
            'details_programme' => $detailsProgramme,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_details_programme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DetailsProgramme $detailsProgramme, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        
        $form = $this->createForm(DetailsProgrammeType::class, $detailsProgramme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_back_details_programme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/details_programme/edit.html.twig', [
            'details_programme' => $detailsProgramme,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_back_details_programme_delete', methods: ['POST'])]
    public function delete(Request $request, DetailsProgramme $detailsProgramme, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$detailsProgramme->getId(), $request->request->get('_token'))) {
            $entityManager->remove($detailsProgramme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_details_programme_index', [
            'currentUser' => $currentUser

        ], Response::HTTP_SEE_OTHER);
    }







    /*#[Route('/envoyer-programme', name: 'envoyer_programme', methods: ['POST'])]
    public function envoyerProgramme(): JsonResponse
    {
        // Traitez la demande d'envoi du programme ici
        
        // Redirigez vers la dashboard Adhérent
        return new JsonResponse(['url' => $this->generateUrl('dashboard_adherent')]);
    }*/

}
