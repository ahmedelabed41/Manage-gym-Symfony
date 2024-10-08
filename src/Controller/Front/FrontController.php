<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Entity\TypeProgramme;
use App\Entity\ImageUser;
use App\Entity\ImageBanniere;
use App\Repository\BanniereRepository;
use App\Repository\ExerciceRepository;
use App\Repository\ImageBanniereRepository;
use App\Repository\TypeProgrammeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class FrontController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(TypeProgrammeRepository $typeProgrammeRepository,ImageBanniereRepository $imageBanniereRepository, BanniereRepository $banniereRepository, MailerInterface $mailer, UserRepository $userRepository, ExerciceRepository $exerciceRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $bannieres = $banniereRepository->findAll(); 
        $imageBanniere = $imageBanniereRepository->findAll(); 


        $exercices = $exerciceRepository->findAll();
        $typeProgramme = $typeProgrammeRepository->find('id');
        $users = $userRepository->findBy(['tache' => 'ROLE_COACH']);
        $currentUser = $this->getUser();

        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
            'typeProgrammes' => $typeProgrammeRepository->findAll(),
            'typeProgramme' => $typeProgramme,
            'exercices' => $exercices,
            'users' => $users,
            'currentUser' => $currentUser,
            'bannieres' => $bannieres,
            'imageBanniere' => $imageBanniere
            
        ]);
    }

    #[Route('/affichage/{id}', name: 'app_front_affichage_show')]
    public function Affichage($id,ExerciceRepository $exerciceRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('front/affichage/index.html.twig', [
            'exercices'  => $exerciceRepository ->findBy(['id' => $id]),
            'currentUser' => $currentUser
        ]);
    }


    

    /*#[Route('/description/{id}', name: 'app_back_type_programme_show')]
    public function afficher($id, TypeProgrammeRepository $typeProgrammeRepository): Response
    {
    $programme = $typeProgrammeRepository->find($id);
    if (!$programme) {
        throw $this->createNotFoundException('Programme non trouvé');
    }

    return $this->render('index.html.twig', [
        'programme' => $programme,
    ]);*/
    


  
}


