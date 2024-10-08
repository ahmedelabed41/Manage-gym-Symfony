<?php

namespace App\Controller\Front;

use App\Entity\ImageUser;
use App\Entity\User;
use App\Form\ImageUserType;
use App\Repository\ImageUserRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/front/image/user')]
class ImageUserController extends AbstractController
{
    #[Route('/', name: 'app_front_image_user_index', methods: ['GET'])]
    public function index(ImageUserRepository $imageUserRepository): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('front/image_user/index.html.twig', [
            'image_users' => $imageUserRepository->findAll(),
            'currentUser' => $currentUser
        ]);
    }

    #[Route('profil', name: 'app_profil', methods: ['GET', 'POST'])]
#[IsGranted('ROLE_USER')]
public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
{
    // Get the current user
    $user = $this->getUser();
    
    // Get the existing ImageUser entity for the current user
    $existingImageUser = $entityManager->getRepository(ImageUser::class)->findOneBy(['user' => $user]);

    // Create a new instance of ImageUser or use the existing one
    $imageUser = $existingImageUser ?? new ImageUser();

    // Create the form and handle the request
    $form = $this->createForm(ImageUserType::class, $imageUser);
    $form->handleRequest($request);
    
    // Check if the form is submitted and valid
    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile $imageFile */
        $imageFile = $form->get('image')->getData();
        
        // Check if an image file is uploaded
        if ($imageFile) {
            // If there is an existing image, delete it
            if ($existingImageUser && $existingImageUser->getImage()) {
                $fileUploader->removeImage($existingImageUser->getImage());
            }
            
            // Upload the image and get the filename
            $imageFilename = $fileUploader->uploadImage($imageFile);
            
            // Set the image filename and user
            $imageUser->setImage($imageFilename);
            $imageUser->setUser($user);
            
            // Persist and flush the entity
            $entityManager->persist($imageUser);
            $entityManager->flush();
            
            // Redirect to the profile page
            return $this->redirectToRoute('app_profil', [], Response::HTTP_SEE_OTHER);
        }
    }
    
    // Render the form view
    return $this->render('front/image_user/new.html.twig', [
        'form' => $form->createView(),
        'user' => $user,
    ]);
}


    

    #[Route('/{id}', name: 'app_front_image_user_show', methods: ['GET'])]
    public function show(ImageUser $imageUser): Response
    {
        return $this->render('front/image_user/show.html.twig', [
            'image_user' => $imageUser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_front_image_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ImageUser $imageUser, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImageUserType::class, $imageUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_front_image_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/image_user/edit.html.twig', [
            'image_user' => $imageUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_front_image_user_delete', methods: ['POST'])]
    public function delete(Request $request, ImageUser $imageUser, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imageUser->getId(), $request->request->get('_token'))) {
            $entityManager->remove($imageUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_front_image_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
