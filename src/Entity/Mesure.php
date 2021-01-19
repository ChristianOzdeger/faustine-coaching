<?php

namespace App\Entity;

use App\Repository\MesureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MesureRepository::class)
 */
class Mesure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $poids;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $bras;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $buste;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $ventre;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hanches;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cuisses;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="mesures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    public function __construct()
    {
        $this->createdAt = new \DateTime;
        $this->date = new \DateTime;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(?float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getBras(): ?float
    {
        return $this->bras;
    }

    public function setBras(?float $bras): self
    {
        $this->bras = $bras;

        return $this;
    }

    public function getBuste(): ?float
    {
        return $this->buste;
    }

    public function setBuste(?float $buste): self
    {
        $this->buste = $buste;

        return $this;
    }

    public function getVentre(): ?float
    {
        return $this->ventre;
    }

    public function setVentre(?float $ventre): self
    {
        $this->ventre = $ventre;

        return $this;
    }

    public function getHanches(): ?float
    {
        return $this->hanches;
    }

    public function setHanches(?float $hanches): self
    {
        $this->hanches = $hanches;

        return $this;
    }

    public function getCuisses(): ?float
    {
        return $this->cuisses;
    }

    public function setCuisses(?float $cuisses): self
    {
        $this->cuisses = $cuisses;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
