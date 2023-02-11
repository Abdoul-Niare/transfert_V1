<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraint as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $ville = null;

    #[ORM\OneToMany(mappedBy: 'expediteur', targetEntity: Transfert::class)]
    private Collection $expediteurs;

    #[ORM\OneToMany(mappedBy: 'agentLivreur', targetEntity: Transfert::class)]
    private Collection $agentLivreurs;

    #[ORM\Column(length: 45)]
    private ?string $nom = null;

    #[ORM\Column(length: 45)]
    private ?string $prenom = null;

    #[ORM\Column(length: 45)]
    private ?string $mail = null;

   

    public function __construct()
    {
        $this->expediteurs = new ArrayCollection();
        $this->agentLivreurs = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->nom." ".$this->prenom." (".$this->username.")";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    
    // private ?string $painPassword = null;


    //   /**
    //  *  Get the value of Plainpassword.
    //  */
    // public function getPlainPassword()
    // {
    //     return $this->plainPassword;
    // }

    //  /**
    //  *  Set the value of Plainpassword.
    //  * @return self
    //  */
    // public function setPlainPassword(string $plainPassword): self
    // {
    //     $this->plainPassword = $plainPassword;

    //     return $this;
    // }




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
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, Transfert>
     */
    public function getExpediteurs(): Collection
    {
        return $this->expediteurs;
    }

    public function addExpediteur(Transfert $expediteur): self
    {
        if (!$this->expediteurs->contains($expediteur)) {
            $this->expediteurs->add($expediteur);
            $expediteur->setExpediteur($this);
        }

        return $this;
    }

    public function removeExpediteur(Transfert $expediteur): self
    {
        if ($this->expediteurs->removeElement($expediteur)) {
            // set the owning side to null (unless already changed)
            if ($expediteur->getExpediteur() === $this) {
                $expediteur->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transfert>
     */
    public function getAgentLivreurs(): Collection
    {
        return $this->agentLivreurs;
    }

    public function addAgentLivreur(Transfert $agentLivreur): self
    {
        if (!$this->agentLivreurs->contains($agentLivreur)) {
            $this->agentLivreurs->add($agentLivreur);
            $agentLivreur->setAgentLivreur($this);
        }

        return $this;
    }

    public function removeAgentLivreur(Transfert $agentLivreur): self
    {
        if ($this->agentLivreurs->removeElement($agentLivreur)) {
            // set the owning side to null (unless already changed)
            if ($agentLivreur->getAgentLivreur() === $this) {
                $agentLivreur->setAgentLivreur(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }
}
