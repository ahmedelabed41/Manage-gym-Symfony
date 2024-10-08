<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassesTimetableController extends AbstractController
{
    #[Route('/class-timetable', name: 'class-timetable')]
    public function index(): Response
    {
         /** @var User $currentUser */
         $currentUser = $this->getUser();
        return $this->render('front/classes_timetable/index.html.twig', [
            'controller_name' => 'ClassesTimetableController',
            'currentUser' => $currentUser
        ]);
    }
}
