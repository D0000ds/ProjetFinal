<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomClient = null;

    #[ORM\Column(length: 100)]
    private ?string $prenomClient = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseFacturation = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column(length: 255)]
    private ?string $libelleArticle = null;

    #[ORM\Column]
    private ?int $qteArticle = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroDeFacturation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCommande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): static
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenomClient;
    }

    public function setPrenomClient(string $prenomClient): static
    {
        $this->prenomClient = $prenomClient;

        return $this;
    }

    public function getAdresseFacturation(): ?string
    {
        return $this->adresseFacturation;
    }

    public function setAdresseFacturation(string $adresseFacturation): static
    {
        $this->adresseFacturation = $adresseFacturation;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getLibelleArticle(): ?string
    {
        return $this->libelleArticle;
    }

    public function setLibelleArticle(string $libelleArticle): static
    {
        $this->libelleArticle = $libelleArticle;

        return $this;
    }

    public function getQteArticle(): ?int
    {
        return $this->qteArticle;
    }

    public function setQteArticle(int $qteArticle): static
    {
        $this->qteArticle = $qteArticle;

        return $this;
    }

    public function getNumeroDeFacturation(): ?string
    {
        return $this->numeroDeFacturation;
    }

    public function setNumeroDeFacturation(string $numeroDeFacturation): static
    {
        $this->numeroDeFacturation = $numeroDeFacturation;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }
}
