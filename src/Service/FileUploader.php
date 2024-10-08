<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        private string $targetDirectory,
        private string $imageTargetDirectory,
        private SluggerInterface $slugger,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);

        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }



    public function uploadImage(UploadedFile $fileImage): string
    {
        $originalFileImagename = pathinfo($fileImage->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileImagename = $this->slugger->slug($originalFileImagename);
        $fileImageName = $safeFileImagename.'-'.uniqid().'.'.$fileImage->guessExtension();

        try {
            $fileImage->move($this->getImageTargetDirectory(), $fileImageName);

        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileImageName;
    }

    public function removeImage($fileName)
    {
        $filePath = $this->getImageTargetDirectory().'/'.$fileName;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

   
    

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function getImageTargetDirectory(): string
    {
        return $this->imageTargetDirectory;
    }
}


?>