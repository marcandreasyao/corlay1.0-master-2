<?php

namespace App\Entity;

use App\Repository\CoutsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoutsRepository::class)
 */
class Couts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $super;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $gasoil;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $petrole;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $ddo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $ddoad;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $butane;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $btc;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $bt6kg;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $bt12kg;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fuel;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $annee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuper(): ?float
    {
        return $this->super;
    }

    public function setSuper(?float $super): self
    {
        $this->super = $super;

        return $this;
    }

    public function getGasoil(): ?float
    {
        return $this->gasoil;
    }

    public function setGasoil(?float $gasoil): self
    {
        $this->gasoil = $gasoil;

        return $this;
    }

    public function getPetrole(): ?float
    {
        return $this->petrole;
    }

    public function setPetrole(?float $petrole): self
    {
        $this->petrole = $petrole;

        return $this;
    }

    public function getDdo(): ?float
    {
        return $this->ddo;
    }

    public function setDdo(?float $ddo): self
    {
        $this->ddo = $ddo;

        return $this;
    }

    public function getDdoad(): ?float
    {
        return $this->ddoad;
    }

    public function setDdoad(?float $ddoad): self
    {
        $this->ddoad = $ddoad;

        return $this;
    }

    public function getButane(): ?float
    {
        return $this->butane;
    }

    public function setButane(?float $butane): self
    {
        $this->butane = $butane;

        return $this;
    }

    public function getBtc(): ?float
    {
        return $this->btc;
    }

    public function setBtc(?float $btc): self
    {
        $this->btc = $btc;

        return $this;
    }

    public function getBt6kg(): ?float
    {
        return $this->bt6kg;
    }

    public function setBt6kg(?float $bt6kg): self
    {
        $this->bt6kg = $bt6kg;

        return $this;
    }

    public function getBt12kg(): ?float
    {
        return $this->bt12kg;
    }

    public function setBt12kg(?float $bt12kg): self
    {
        $this->bt12kg = $bt12kg;

        return $this;
    }

    public function getFuel(): ?float
    {
        return $this->fuel;
    }

    public function setFuel(?float $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(?string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }
}
