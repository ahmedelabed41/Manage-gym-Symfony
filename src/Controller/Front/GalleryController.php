<?php

namespace App\Controller\Front;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    #[Route('/gallery', name: 'gallery')]
    public function gallery(): Response
    {
         /** @var User $currentUser */
         $currentUser = $this->getUser();
        return $this->render('front/gallery/index.html.twig', [
            'controller_name' => 'GalleryController',
            'currentUser' => $currentUser
        ]);
    }

}
