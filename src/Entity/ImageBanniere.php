<?php

namespace App\Entity;

use App\Repository\ImageBanniereRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageBanniereRepository::class)]
class ImageBanniere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'imageBannieres')]
    private ?Banniere $banniere = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBanniere(): ?Banniere
    {
        return $this->banniere;
    }

    public function setBanniere(?Banniere $banniere): static
    {
        $this->banniere = $banniere;

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
