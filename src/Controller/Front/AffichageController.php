<?php

namespace App\Controller\Front;

use App\Entity\Exercice;
use App\Entity\TypeProgramme;
use App\Repository\ExerciceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AffichageController extends AbstractController
{
    #[Route('/affichage/{id}', name: 'affichage_detail', methods: ['GET'])]
    public function index(Exercice $exercice): Response
    {
        $currentUser = $this->getUser();
        return $this->render('front/affichage/index.html.twig', [
            'controller_name' => 'AffichageController',
            'exercice' => $exercice,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/affichage2/{id}', name: 'affichage_details', methods: ['GET'])]
    public function index2(TypeProgramme $typeProgramme): Response
    {
        $currentUser = $this->getUser();
        return $this->render('front/affichage/index2.html.twig', [
            'typeProgramme' => $typeProgramme,
            'currentUser' => $currentUser
        ]);
    }
}


