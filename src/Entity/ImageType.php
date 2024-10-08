<?php

namespace App\Entity;

use App\Repository\ImageTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageTypeRepository::class)]
class ImageType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'imageTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeProgramme $typeProgramme = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeProgramme(): ?TypeProgramme
    {
        return $this->typeProgramme;
    }

    public function setTypeProgramme(?TypeProgramme $typeProgramme): static
    {
        $this->typeProgramme = $typeProgramme;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
