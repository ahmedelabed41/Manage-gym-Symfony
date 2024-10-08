<?php

namespace App\Controller\Front;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutUsController extends AbstractController
{
    #[Route('/about_us', name: 'about_us')]
    public function aboutus(UserRepository $userRepository): Response
    {
        $currentUser = $this->getUser();
        $users = $userRepository->findBy(['tache' => 'ROLE_COACH']);
        return $this->render('front/about_us/index.html.twig', [
            'users' => $users,
            'currentUser' => $currentUser
        ]);
    }
}
