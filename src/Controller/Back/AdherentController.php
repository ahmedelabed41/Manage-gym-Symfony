<?php

namespace App\Controller\Back;

use App\Entity\Adherent;
use App\Entity\User;
use App\Form\AdherentType;
use App\Form\UserType;
use App\Repository\AdherentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;

#[Route('/back/adherent')]
class AdherentController extends AbstractController
{
    #[Route('/', name: 'app_back_adherent_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, AdherentRepository $adherentRepository, UserRepository $userRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $userRepository = $entityManager->getRepository(User::class);
        $users = $userRepository->findBy(['tache' => 'ROLE_USER']);
        return $this->render('/back/adherent/index.html.twig', [
            'adherent' => $adherentRepository->findAll(),
            'users' => $users,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/new', name: 'app_back_adherent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $user = new User();
        $form = $this->createForm(AdherentType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_adherent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/adherent/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_back_adherent_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/adherent/show.html.twig', [
            'user' => $user,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_adherent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $form = $this->createForm(AdherentType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_back_adherent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/adherent/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_back_adherent_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_adherent_index', [
            'currentUser' => $currentUser
        ], Response::HTTP_SEE_OTHER);
    }
}
