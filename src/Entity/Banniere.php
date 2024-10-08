<?php

namespace App\Entity;

use App\Repository\BanniereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BanniereRepository::class)]
class Banniere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $textButton = null;

    #[ORM\OneToMany(mappedBy: 'banniere', targetEntity: ImageBanniere::class, cascade: ['persist'])]
    private Collection $imageBannieres;

    public function __construct()
    {
        $this->imageBannieres = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTextButton(): ?string
    {
        return $this->textButton;
    }

    public function setTextButton(string $textButton): static
    {
        $this->textButton = $textButton;

        return $this;
    }

    /**
     * @return Collection<int, ImageBanniere>
     */
    public function getImageBannieres(): Collection
    {
        return $this->imageBannieres;
    }

    public function addImageBanniere(ImageBanniere $imageBanniere): static
    {
        if (!$this->imageBannieres->contains($imageBanniere)) {
            $this->imageBannieres->add($imageBanniere);
            $imageBanniere->setBanniere($this);
        }

        return $this;
    }

    public function removeImageBanniere(ImageBanniere $imageBanniere): static
    {
        if ($this->imageBannieres->removeElement($imageBanniere)) {
            // set the owning side to null (unless already changed)
            if ($imageBanniere->getBanniere() === $this) {
                $imageBanniere->setBanniere(null);
            }
        }

        return $this;
    }

    
}
