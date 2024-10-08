<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank(message: 'L\'email ne peut pas être vide')]
    #[Assert\Length(
        max: 50,
        maxMessage: 'L\'email ne peut pas dépasser {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|live\.com)$/',
        message: 'L\'adresse email doit appartenir à l\'un des domaines suivants : gmail.com, yahoo.com, live.com.'
    )]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le nom ne peut pas etre vide')]
    #[Assert\Length(
        min: 3,
        minMessage: 'Le nom doit faire au moins 3 caractères'
    )]
    #[Assert\Regex(
        pattern: '/^\D+$/',
        message: 'Le nom ne peut pas contenir de chiffres'
    )]
    private ?string $nom = null;
    

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le prénom ne peut pas etre vide')]
    #[Assert\Length(
        min: 3,
        minMessage: 'Le prénom doit faire au moins 3 caractères'
    )]
    #[Assert\Regex(
        pattern: '/^\D+$/',
        message: 'Le prénom ne peut pas contenir de chiffres'
    )]
    private ?string $prenom = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le téléphone ne peut pas etre vide')]
    #[Assert\Length(
        min: 8,
        max: 8,
        minMessage: 'Le téléphone doit faire exactement composé en 8 chiffres',
        maxMessage: 'Le téléphone doit faire exactement composé en 8 chiffres'
    )]
    private ?int $telephone = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le numéro de la CIN ne peut pas etre vide')]
    #[Assert\Length(
        min: 8,
        max: 8,
        minMessage: 'Le numéro de la CIN doit faire exactement composé en 8 chiffres',
        maxMessage: 'Le numéro de la CIN doit faire exactement composé en 8 chiffres'
    )]
    private ?int $cin = null;

    #[ORM\Column(length: 6)]
    private ?string $sexe = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Abonnements::class)]
    private Collection $abonnements;

    #[ORM\Column]
    private ?bool $IsValide = null;

    #[ORM\OneToMany(mappedBy: 'coach', targetEntity: Affectation::class)]
    private Collection $affectations;

    #[ORM\Column(length: 255)]
    private ?string $tache = null;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Programme::class)]
    private Collection $programmes;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ImageUser::class, cascade: ['persist'])]
    private Collection $imageUsers;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profileImage = null;

    /**
     * @var Collection<int, Programme>
     */
    #[ORM\OneToMany(mappedBy: 'Coach', targetEntity: Programme::class)]
    private Collection $Coach;

    

 



    

    public function __construct()
    {
        $this->abonnements = new ArrayCollection();
        $this->affectations = new ArrayCollection();
        $this->programmes = new ArrayCollection();
        $this->imageUsers = new ArrayCollection();
        $this->Coach = new ArrayCollection();
    
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return Collection<int, Abonnements>
     */
    public function getAbonnements(): Collection
    {
        return $this->abonnements;
    }

    public function addAbonnement(Abonnements $abonnement): static
    {
        if (!$this->abonnements->contains($abonnement)) {
            $this->abonnements->add($abonnement);
            $abonnement->setUser($this);
        }

        return $this;
    }

    public function removeAbonnement(Abonnements $abonnement): static
    {
        if ($this->abonnements->removeElement($abonnement)) {
            // set the owning side to null (unless already changed)
            if ($abonnement->getUser() === $this) {
                $abonnement->setUser(null);
            }
        }

        return $this;
    }

    public function isIsValide(): ?bool
    {
        return $this->IsValide;
    }

    public function setIsValide(bool $IsValide): static
    {
        $this->IsValide = $IsValide;

        return $this;
    }

    /**
     * @return Collection<int, Affectation>
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): static
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations->add($affectation);
            $affectation->setCoach($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): static
    {
        if ($this->affectations->removeElement($affectation)) {
            // set the owning side to null (unless already changed)
            if ($affectation->getCoach() === $this) {
                $affectation->setCoach(null);
            }
        }

        return $this;
    }

    public function getTache(): ?string
    {
        return $this->tache;
    }

    public function setTache(string $tache): static
    {
        $this->tache = $tache;

        return $this;
    }

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
            $programme->setUserId($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getUserId() === $this) {
                $programme->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ImageUser>
     */
    public function getImageUsers(): Collection
    {
        return $this->imageUsers;
    }

    public function addImageUser(ImageUser $imageUser): static
    {
        if (!$this->imageUsers->contains($imageUser)) {
            $this->imageUsers->add($imageUser);
            $imageUser->setUser($this);
        }

        return $this;
    }

    public function removeImageUser(ImageUser $imageUser): static
    {
        if ($this->imageUsers->removeElement($imageUser)) {
            // set the owning side to null (unless already changed)
            if ($imageUser->getUser() === $this) {
                $imageUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getCoach(): Collection
    {
        return $this->Coach;
    }

    public function addCoach(Programme $coach): static
    {
        if (!$this->Coach->contains($coach)) {
            $this->Coach->add($coach);
            $coach->setCoach($this);
        }

        return $this;
    }

    public function removeCoach(Programme $coach): static
    {
        if ($this->Coach->removeElement($coach)) {
            // set the owning side to null (unless already changed)
            if ($coach->getCoach() === $this) {
                $coach->setCoach(null);
            }
        }

        return $this;
    }

 

    

   
  
}
