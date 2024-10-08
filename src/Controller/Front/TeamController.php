<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/team', name: 'team')]
    public function team(): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('front/team/index.html.twig', [
            'controller_name' => 'TeamController',
            'currentUser' => $currentUser
        ]);
    }
}
