<?php

namespace App\Controller\Front;

use App\Repository\ExerciceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    #[Route('/services', name: 'services')]
    public function services(ExerciceRepository $exerciceRepository): Response
    {
        $currentUser = $this->getUser();
        $exercices = $exerciceRepository->findAll();
        return $this->render('front/services/index.html.twig', [
            'controller_name' => 'ServicesController',
            'exercices' => $exercices,
            'currentUser' => $currentUser
        ]);
    }
}
