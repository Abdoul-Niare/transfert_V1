<?php

namespace App\Entity;

use App\Repository\TransfertRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransfertRepository::class)]
class Transfert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $statut = Null;

    #[ORM\Column(length: 45)]
    private ?string $codeSecret = null;

    #[ORM\Column]
    private ?float $montTransfert = null;

    #[ORM\Column]
    private ?float $montBenef = null;

    #[ORM\Column]
    private ?float $fraisTransfert = null;

    #[ORM\Column]
    private ?float $comTransfert = null;

    #[ORM\Column]
    private ?float $comAgentLivreur = null;

    #[ORM\Column(length: 45)]
    private ?string $nomBenef = null;

    #[ORM\Column(length: 14)]
    private ?string $numBenef = null;

    #[ORM\Column(length: 14)]
    private ?string $numTelBenef = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnvoi = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePrisCharge = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateLivr = null;

    #[ORM\Column]
    private ?bool $is_visible = null;

    #[ORM\ManyToOne(inversedBy: 'villes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $ville = null;

    #[ORM\ManyToOne(inversedBy: 'expediteurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $expediteur = null;

    #[ORM\ManyToOne(inversedBy: 'agentLivreurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $agentLivreur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCodeSecret(): ?string
    {
        return $this->codeSecret;
    }

    public function setCodeSecret(string $codeSecret): self
    {
        $this->codeSecret = $codeSecret;

        return $this;
    }

    public function getMontTransfert(): ?float
    {
        return $this->montTransfert;
    }

    public function setMontTransfert(float $montTransfert): self
    {
        $this->montTransfert = $montTransfert;

        return $this;
    }

    public function getMontBenef(): ?float
    {
        return $this->montBenef;
    }

    public function setMontBenef(float $montBenef): self
    {
        $this->montBenef = $montBenef;

        return $this;
    }

    public function getFraisTransfert(): ?float
    {
        return $this->fraisTransfert;
    }

    public function setFraisTransfert(float $fraisTransfert): self
    {
        $this->fraisTransfert = $fraisTransfert;

        return $this;
    }

    public function getComTransfert(): ?float
    {
        return $this->comTransfert;
    }

    public function setComTransfert(float $comTransfert): self
    {
        $this->comTransfert = $comTransfert;

        return $this;
    }

    public function getComAgentLivreur(): ?float
    {
        return $this->comAgentLivreur;
    }

    public function setComAgentLivreur(float $comAgentLivreur): self
    {
        $this->comAgentLivreur = $comAgentLivreur;

        return $this;
    }

    public function getNomBenef(): ?string
    {
        return $this->nomBenef;
    }

    public function setNomBenef(string $nomBenef): self
    {
        $this->nomBenef = $nomBenef;

        return $this;
    }

    public function getNumBenef(): ?string
    {
        return $this->numBenef;
    }

    public function setNumBenef(string $numBenef): self
    {
        $this->numBenef = $numBenef;

        return $this;
    }

    public function getNumTelBenef(): ?string
    {
        return $this->numTelBenef;
    }

    public function setNumTelBenef(string $numTelBenef): self
    {
        $this->numTelBenef = $numTelBenef;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): self
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getDatePrisCharge(): ?\DateTimeInterface
    {
        return $this->datePrisCharge;
    }

    public function setDatePrisCharge(?\DateTimeInterface $datePrisCharge): self
    {
        $this->datePrisCharge = $datePrisCharge;

        return $this;
    }

    public function getDateLivr(): ?\DateTimeInterface
    {
        return $this->dateLivr;
    }

    public function setDateLivr(?\DateTimeInterface $dateLivr): self
    {
        $this->dateLivr = $dateLivr;

        return $this;
    }

    public function isIsVisible(): ?bool
    {
        return $this->is_visible;
    }

    public function setIsVisible(bool $is_visible): self
    {
        $this->is_visible = $is_visible;

        return $this;
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

    public function getExpediteur(): ?User
    {
        return $this->expediteur;
    }

    public function setExpediteur(?User $expediteur): self
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getAgentLivreur(): ?User
    {
        return $this->agentLivreur;
    }

    public function setAgentLivreur(?User $agentLivreur): self
    {
        $this->agentLivreur = $agentLivreur;

        return $this;
    }
}
