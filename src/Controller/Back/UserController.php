<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/back/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_back_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        /*$currentUser = $this->getUser();
        $userRepository = $entityManager->getRepository(User::class);

        return $this->render('/back/user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'currentUser' => $currentUser
        ]);*/


        $currentUser = $this->getUser();
        $users = $userRepository->findAll();
        return $this->render('back/user/index.html.twig', [
            'currentUser' => $currentUser,
            'users' => $users
            
        ]);
    }
    

    #[Route('/new', name: 'app_back_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_back_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'currentUser' => $currentUser
        ]);
    }
    

    #[Route('/{id}/edit', name: 'app_back_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $roles = $form['roles']->getData();
            // Assuming roles is an array, serialize it to a string
            $tache = implode(',', $roles);
            $user->setTache($tache);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'currentUser' => $currentUser
        ]);
    }
    

    #[Route('/{id}', name: 'app_back_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_user_index', [
            'currentUser' => $currentUser
        ], Response::HTTP_SEE_OTHER);
    }

    
   
}
