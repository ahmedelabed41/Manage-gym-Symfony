<?php

namespace App\Controller\Back;

use App\Entity\ImageType;
use App\Entity\TypeProgramme;
use App\Form\TypeProgrammeType;
use App\Repository\TypeProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;

#[Route('/back/type/programme')]
class TypeProgrammeController extends AbstractController
{
    #[Route('/', name: 'app_back_type_programme_index', methods: ['GET'])]
    public function index(TypeProgrammeRepository $typeProgrammeRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/type_programme/index.html.twig', [
            'type_programmes' => $typeProgrammeRepository->findAll(),
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/new', name: 'app_back_type_programme_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $typeProgramme = new TypeProgramme();
        $form = $this->createForm(TypeProgrammeType::class, $typeProgramme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFiles = $form->get('imageType')->getData();
            if ($imageFiles) {
                foreach ($imageFiles as  $imageFile) {
                    $imageFilename = $fileUploader->uploadImage($imageFile, true);
                    $imageType= new ImageType();
                    $imageType->setImage($imageFilename);
                    $typeProgramme->addImageType($imageType);
                }
            }
            $entityManager->persist($typeProgramme);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_type_programme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/type_programme/new.html.twig', [
            'type_programme' => $typeProgramme,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_back_type_programme_show', methods: ['GET'])]
    public function show(TypeProgramme $typeProgramme): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('back/type_programme/show.html.twig', [
            'type_programme' => $typeProgramme,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_type_programme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeProgramme $typeProgramme, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $form = $this->createForm(TypeProgrammeType::class, $typeProgramme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFiles = $form->get('imageType')->getData();

            if ($imageFiles) {
                // Remove old images
                foreach ($typeProgramme->getImageTypes() as $oldImage) {
                    $typeProgramme->removeImageType($oldImage);
                    // Optionally, you can also remove the file from the filesystem if needed
                    $fileUploader->removeImage($oldImage->getImage());
                    $entityManager->remove($oldImage);
                }
                // Add new images
                foreach ($imageFiles as $imageFile) {
                    $imageFilename = $fileUploader->uploadImage($imageFile, true);
                    $imageType = new ImageType();
                    $imageType->setImage($imageFilename);
                    $typeProgramme->addImageType($imageType);
                }
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_back_type_programme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/type_programme/edit.html.twig', [
            'type_programme' => $typeProgramme,
            'form' => $form,
            'currentUser' => $currentUser
        ]);
    }

    #[Route('/{id}', name: 'app_back_type_programme_delete', methods: ['POST'])]
    public function delete(Request $request, TypeProgramme $typeProgramme, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$typeProgramme->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeProgramme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_back_type_programme_index', [
            'currentUser' => $currentUser
        ], Response::HTTP_SEE_OTHER);
    }
}
