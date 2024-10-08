<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'programmes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    #[ORM\ManyToOne(inversedBy: 'programmes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeProgramme $typeId = null;

    #[ORM\Column(length: 255)]
    private ?string $dateDebut = null;

    #[ORM\Column(length: 255)]
    private ?string $dateFin = null;


    #[ORM\OneToMany(mappedBy: 'programme', targetEntity: DetailsProgramme::class)]
    private Collection $detailsProgrammes;

    #[ORM\ManyToOne(inversedBy: 'Coach')]
    private ?User $Coach = null;

    

    public function __construct()
    {
        $this->detailsProgrammes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getTypeId(): ?TypeProgramme
    {
        return $this->typeId;
    }

    public function setTypeId(?TypeProgramme $typeId): static
    {
        $this->typeId = $typeId;

        return $this;
    }

    public function getDateDebut(): ?string
    {
        return $this->dateDebut;
    }

    public function setDateDebut(string $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?string
    {
        return $this->dateFin;
    }

    public function setDateFin(string $dateFin): static
    {
        $this->dateFin = $dateFin;

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
            $detailsProgramme->setProgramme($this);
        }

        return $this;
    }

    public function removeDetailsProgramme(DetailsProgramme $detailsProgramme): static
    {
        if ($this->detailsProgrammes->removeElement($detailsProgramme)) {
            // set the owning side to null (unless already changed)
            if ($detailsProgramme->getProgramme() === $this) {
                $detailsProgramme->setProgramme(null);
            }
        }

        return $this;
    }

    public function getCoach(): ?User
    {
        return $this->Coach;
    }

    public function setCoach(?User $Coach): static
    {
        $this->Coach = $Coach;

        return $this;
    }

    
}
