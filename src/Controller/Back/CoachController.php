<?php

namespace App\Controller\Back;

use App\Entity\Coach;
use App\Entity\User;
use App\Form\CoachType;
use App\Form\UserType;
use App\Repository\CoachRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/coach')]
class CoachController extends AbstractController
{
    #[Route('/', name: 'app_back_coach_index', methods: ['GET'])]
    public function index(CoachRepository $coachRepository, UserRepository $userRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $users = $userRepository->findBy(['tache' => 'ROLE_COACH']);
        return $this->render('back/coach/index.html.twig', [
            'users' => $userRepository->findBy(['tache' => 'ROLE_COACH']),
            'users' => $users,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/new', name: 'app_back_coach_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $user = new User();
        $form = $this->createForm(CoachType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_coach_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/coach/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_back_coach_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/coach/show.html.twig', [
            'user' => $user,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_coach_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Coach $coach, User $user, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_back_coach_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/coach/edit.html.twig', [
            'coach' => $coach,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_back_coach_delete', methods: ['POST'])]
    public function delete(Request $request, Coach $coach, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$coach->getId(), $request->request->get('_token'))) {
            $entityManager->remove($coach);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_coach_index', [
            'currentUser' => $currentUser
        ], Response::HTTP_SEE_OTHER);
    }
}
