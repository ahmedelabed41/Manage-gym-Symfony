<?php

namespace App\Entity;

use App\Repository\TypeProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeProgrammeRepository::class)]
class TypeProgramme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Exercice::class)]
    private Collection $exercices;

    #[ORM\OneToMany(mappedBy: 'typeId', targetEntity: Programme::class)]
    private Collection $programmes;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'typeProgramme', targetEntity: ImageType::class, cascade: ['persist'])]
    private Collection $imageTypes;



    public function __construct()
    {
        $this->exercices = new ArrayCollection();
        $this->programmes = new ArrayCollection();
        $this->imageTypes = new ArrayCollection();
    }



 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    

    /**
     * @return Collection<int, Exercice>
     */
    /*public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercice $exercice): static
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices->add($exercice);
            $exercice->setType($this);
        }

        return $this;
    }

    public function removeExercice(Exercice $exercice): static
    {
        if ($this->exercices->removeElement($exercice)) {
            // set the owning side to null (unless already changed)
            if ($exercice->getType() === $this) {
                $exercice->setType(null);
            }
        }

        return $this;
    }*/

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): static
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes->add($programme);
            $programme->setTypeId($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getTypeId() === $this) {
                $programme->setTypeId(null);
            }
        }

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
     * @return Collection<int, ImageType>
     */
    public function getImageTypes(): Collection
    {
        return $this->imageTypes;
    }

    public function addImageType(ImageType $imageType): static
    {
        if (!$this->imageTypes->contains($imageType)) {
            $this->imageTypes->add($imageType);
            $imageType->setTypeProgramme($this);
        }

        return $this;
    }

    public function removeImageType(ImageType $imageType): static
    {
        if ($this->imageTypes->removeElement($imageType)) {
            // set the owning side to null (unless already changed)
            if ($imageType->getTypeProgramme() === $this) {
                $imageType->setTypeProgramme(null);
            }
        }

        return $this;
    }

}
