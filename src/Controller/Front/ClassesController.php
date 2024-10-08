<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassesController extends AbstractController
{
    #[Route('/class-details', name: 'classes')]
    public function classes(): Response
    {
         /** @var User $currentUser */
         $currentUser = $this->getUser();
        return $this->render('front/classes/index.html.twig', [
            'controller_name' => 'ClassesController',
            'currentUser' => $currentUser
        ]);
    }
}
