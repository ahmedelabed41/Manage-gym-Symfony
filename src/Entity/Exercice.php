<?php

namespace App\Entity;

use App\Repository\ExerciceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciceRepository::class)]
class Exercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom ne peut pas être vide')]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La description ne peut pas être vide')]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'exercice', targetEntity: VideoExercice::class, cascade: ['persist'])]
    #[Assert\NotBlank(message: 'Le champ vidéos ne peut pas être vide')]
    private Collection $videoExercices;

    
   

    #[ORM\OneToMany(mappedBy: 'exercice', targetEntity: DetailsProgramme::class)]
    private Collection $detailsProgrammes;

   

    #[ORM\OneToMany(mappedBy: 'exercice', targetEntity: ImageExercice::class, cascade: ['persist'])]
    #[Assert\NotBlank(message: 'Le champ image ne peut pas être vide')]
    private Collection $imageExercices;


    public function __construct()
    {
        $this->videoExercices = new ArrayCollection();
        $this->detailsProgrammes = new ArrayCollection();
        $this->imageExercices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return Collection<int, VideoExercice>
     */
    public function getVideoExercices(): Collection
    {
        return $this->videoExercices;
    }

    public function addVideoExercice(VideoExercice $videoExercice): static
    {
        if (!$this->videoExercices->contains($videoExercice)) {
            $this->videoExercices->add($videoExercice);
            $videoExercice->setExercice($this);
        }

        return $this;
    }

    public function removeVideoExercice(VideoExercice $videoExercice): static
    {
        if ($this->videoExercices->removeElement($videoExercice)) {
            // set the owning side to null (unless already changed)
            if ($videoExercice->getExercice() === $this) {
                $videoExercice->setExercice(null);
            }
        }

        return $this;
    }

    

    
    

    


    /**
     * @return Collection<int, DetailsProgramme>
     */
    public function getDetailsProgrammes(): Collection
    {
        return $this->detailsProgrammes;
    }

    public function addDetailsProgramme(DetailsProgramme $detailsProgramme): static
    {
        if (!$this->detailsProgrammes->contains($detailsProgramme)) {
            $this->detailsProgrammes->add($detailsProgramme);
            $detailsProgramme->setExercice($this);
        }

        return $this;
    }

    public function removeDetailsProgramme(DetailsProgramme $detailsProgramme): static
    {
        if ($this->detailsProgrammes->removeElement($detailsProgramme)) {
            // set the owning side to null (unless already changed)
            if ($detailsProgramme->getExercice() === $this) {
                $detailsProgramme->setExercice(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, ImageExercice>
     */
    public function getImageExercices(): Collection
    {
        return $this->imageExercices;
    }

    public function addImageExercice(ImageExercice $imageExercice): static
    {
        if (!$this->imageExercices->contains($imageExercice)) {
            $this->imageExercices->add($imageExercice);
            $imageExercice->setExercice($this);
        }

        return $this;
    }

    public function removeImageExercice(ImageExercice $imageExercice): static
    {
        if ($this->imageExercices->removeElement($imageExercice)) {
            // set the owning side to null (unless already changed)
            if ($imageExercice->getExercice() === $this) {
                $imageExercice->setExercice(null);
            }
        }

        return $this;
    }


    

    
}
