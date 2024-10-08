<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BmiCalculateController extends AbstractController
{
    #[Route('/bmi-calculator', name: 'bmi-calculator')]
    public function bmi(): Response
    {
         /** @var User $currentUser */
         $currentUser = $this->getUser();
        return $this->render('front/bmi_calculate/index.html.twig', [
            'controller_name' => 'BmiCalculateController',
            'currentUser' => $currentUser
        ]);
    }
}
