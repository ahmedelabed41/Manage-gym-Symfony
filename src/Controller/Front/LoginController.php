<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/loginform', name: 'app_login')]
    public function index(): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('login.html.twig', [
            'controller_name' => 'LoginController',
            'currentUser' => $currentUser
        ]);
    }
}
