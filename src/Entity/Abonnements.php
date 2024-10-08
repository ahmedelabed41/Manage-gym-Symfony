<?php

namespace App\Entity;

use App\Repository\AbonnementsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementsRepository::class)]
class Abonnements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'abonnements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /*#[ORM\Column(length: 255)]
    private ?string $dateInscription = null;*/

    #[ORM\Column(length: 255)]
    private ?string $dateDebut = null;

    #[ORM\Column(length: 255)]
    private ?string $dateFin = null;

    /*#[ORM\Column]
    private ?int $renouvellement = null;*/

    #[ORM\Column]
    private ?int $payement = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 15)]
    private ?string $statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /*public function getDateInscription(): ?string
    {
        return $this->dateInscription;
    }

    public function setDateInscription(string $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }*/

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

    /*public function getRenouvellement(): ?int
    {
        return $this->renouvellement;
    }

    public function setRenouvellement(int $renouvellement): static
    {
        $this->renouvellement = $renouvellement;

        return $this;
    }*/

    public function getPayement(): ?int
    {
        return $this->payement;
    }

    public function setPayement(int $payement): static
    {
        $this->payement = $payement;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }



    
}
