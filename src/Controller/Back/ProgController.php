<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgController extends AbstractController
{
    #[Route('/back/prog', name: 'app_back_prog', methods: ['GET','POST'])]
    public function index(): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/prog.html.twig', [
            'controller_name' => 'ProgController',
            'currentUser' => $currentUser
        ]);
    }
}
