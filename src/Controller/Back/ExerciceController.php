<?php

namespace App\Controller\Back;

use App\Entity\Exercice;
use App\Entity\ImageExercice;
use App\Entity\VideoExercice;
use App\Form\ExerciceType;
use App\Repository\ExerciceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;

#[Route('/back/exercice')]
class ExerciceController extends AbstractController
{
    #[Route('/', name: 'app_back_exercice_index', methods: ['GET'])]
    public function index(ExerciceRepository $exerciceRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/exercice/index.html.twig', [
            'exercices' => $exerciceRepository->findAll(),
            'currentUser' => $currentUser
        ]);
    }

    /*#[Route('/new', name: 'app_back_exercice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exercice);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/exercice/new.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
        ]);
    }*/

    #[Route('/new', name: 'app_back_exercice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFiles = $form->get('imageExercice')->getData();
            if ($imageFiles) {
                foreach ($imageFiles as  $imageFile) {
                    $imageFilename = $fileUploader->uploadImage($imageFile, true);
                    $imageExercice= new ImageExercice();
                    $imageExercice->setImage($imageFilename);
                    $exercice->addImageExercice($imageExercice);
                }
            }


            /** @var UploadedFile $videoFile */
            $videoFiles = $form->get('videoExercice')->getData();
            if ($videoFiles) {
                foreach ($videoFiles as  $videoFile) {
                    $videoFilename = $fileUploader->upload($videoFile);
                    $videoExercice= new VideoExercice();
                    $videoExercice->setVideo($videoFilename);
                    $exercice->addVideoExercice($videoExercice);
                }
            }

            

            $entityManager->persist($exercice);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_exercice_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('back/exercice/new.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }










    #[Route('/{id}', name: 'app_back_exercice_show', methods: ['GET'])]
    public function show(Exercice $exercice): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/exercice/show.html.twig', [
            'exercice' => $exercice,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_exercice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exercice $exercice, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFiles = $form->get('imageExercice')->getData();

            if ($imageFiles) {
                // Remove old images
                foreach ($exercice->getImageExercices() as $oldImage) {
                    $exercice->removeImageExercice($oldImage);
                    // Optionally, you can also remove the file from the filesystem if needed
                    $fileUploader->removeImage($oldImage->getImage());
                    $entityManager->remove($oldImage);
                }
                // Add new images
                foreach ($imageFiles as $imageFile) {
                    $imageFilename = $fileUploader->uploadImage($imageFile, true);
                    $imageExercice = new ImageExercice();
                    $imageExercice->setImage($imageFilename);
                    $exercice->addImageExercice($imageExercice);
                }
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_back_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/exercice/edit.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_back_exercice_delete', methods: ['POST'])]
    public function delete(Request $request, Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$exercice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($exercice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_exercice_index', [
            'currentUser' => $currentUser
        ], Response::HTTP_SEE_OTHER);
    }
}
