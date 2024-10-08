<?php

namespace App\Controller\Front;

use App\Entity\Banniere;
use App\Entity\ImageBanniere;
use App\Form\BanniereType;
use App\Repository\BanniereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;

#[Route('/front/banniere')]
class BanniereController extends AbstractController
{
    #[Route('/', name: 'app_front_banniere_index', methods: ['GET'])]
    public function index(BanniereRepository $banniereRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('front/banniere/index.html.twig', [
            'bannieres' => $banniereRepository->findAll(),
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/new', name: 'app_front_banniere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $banniere = new Banniere();
        $form = $this->createForm(BanniereType::class, $banniere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFiles = $form->get('imageBanniere')->getData();
            if ($imageFiles) {
                foreach ($imageFiles as  $imageFile) {
                    $imageFilename = $fileUploader->uploadImage($imageFile, true);
                    $imageBanniere= new ImageBanniere();
                    $imageBanniere->setImage($imageFilename);
                    $banniere->addImageBanniere($imageBanniere);
                }
            }
            $entityManager->persist($banniere);
            $entityManager->flush();

            return $this->redirectToRoute('app_front_banniere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/banniere/new.html.twig', [
            'banniere' => $banniere,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_front_banniere_show', methods: ['GET'])]
    public function show(Banniere $banniere): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('front/banniere/show.html.twig', [
            'banniere' => $banniere,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}/edit', name: 'app_front_banniere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Banniere $banniere, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $form = $this->createForm(BanniereType::class, $banniere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile[] $imageFiles */
            $imageFiles = $form->get('imageBanniere')->getData();
            if ($imageFiles) {
                // Supprimer les anciennes images
                foreach ($banniere->getImageBannieres() as $oldImage) {
                    $fileUploader->removeImage($oldImage->getImage());
                    $banniere->removeImageBanniere($oldImage);
                    $entityManager->remove($oldImage);
                }
                
                // Ajouter les nouvelles images
                foreach ($imageFiles as $imageFile) {
                    $imageFilename = $fileUploader->uploadImage($imageFile, true);
                    $imageBanniere = new ImageBanniere();
                    $imageBanniere->setImage($imageFilename);
                    $banniere->addImageBanniere($imageBanniere);
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_front_banniere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/banniere/edit.html.twig', [
            'banniere' => $banniere,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_front_banniere_delete', methods: ['POST'])]
    public function delete(Request $request, Banniere $banniere, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$banniere->getId(), $request->request->get('_token'))) {
            $entityManager->remove($banniere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_front_banniere_index', [
            'currentUser' => $currentUser
        ], Response::HTTP_SEE_OTHER);
    }
}
