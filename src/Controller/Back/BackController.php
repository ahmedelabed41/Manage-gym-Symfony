<?php

namespace App\Controller\Back;

use App\Repository\AffectationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\CoachRepository;
use App\Repository\ProgrammeRepository;

use App\Repository\DetailsProgrammeRepository;
use App\Repository\ExerciceRepository;
use App\Repository\UserRepository;

class BackController extends AbstractController
{
    #[Route('/back', name: 'app_back')]
    #[IsGranted('ROLE_USER')]
    public function index(UserRepository $userRepository, AffectationRepository $affectationRepository): Response
    {
        $users = $userRepository->findBy(['tache' => 'ROLE_COACH']);
        // Get the currently logged-in user using getUser() method from AbstractController
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        // Find affectations where the current user is the adherent
        $affectations = $affectationRepository->findBy(['adherent' => $currentUser]);

        // Filter the affectations to get the associated coaches
        $users = [];
        foreach ($affectations as $affectation) {
            $user = $affectation->getCoach();
            if ($user && in_array('ROLE_COACH', $user->getRoles())) {
                $users[] = $user;
            }
        }

        return $this->render('back/index.html.twig', [
            'controller_name' => 'BackController',
            'users' => $users,
            'currentUser' => $currentUser,

        ]);
    }

    #[Route('/monprogramme/{id}', name: 'app_back_details_programme_index2', methods: ['GET'])]
    public function index2($id, ProgrammeRepository $programmeRepository, Request $request): Response
    {
        $currentUser = $this->getUser();
        $CoachId = $id;
        if ($CoachId !== null) {
            // Fetch details of the specified programme
            $Programme = $programmeRepository->findBy(['Coach' => $CoachId, 'userId' => $currentUser]);
           
        }

        return $this->render('back/details_programme/index2.html.twig', [
            'programmes' => $Programme,
            'currentUser' => $currentUser,

        ]);
    }


    #[Route('/mondetailprogramme/{id}', name: 'app_back_details_programme_user', methods: ['GET'])]
    public function getDetail($id, DetailsProgrammeRepository $detailsProgrammeRepository, ExerciceRepository $exerciceRepository, ProgrammeRepository $programmeRepository, Request $request): Response
    {
        $currentUser = $this->getUser();
        $CoachId = $id;
        if ($CoachId !== null) {
            // Fetch details of the specified programme
            $detailsProgramme = $detailsProgrammeRepository->findBy(['programme' => $id]);
        }
        
        return $this->render('back/details_programme/detail.html.twig', [
            'details_programmes' => $detailsProgramme,
            'currentUser' => $currentUser,
        ]);
    }
}
