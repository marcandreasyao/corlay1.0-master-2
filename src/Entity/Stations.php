<?php

namespace App\Entity;

use App\Repository\StationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StationsRepository::class)
 */
class Stations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emplacement;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $framecode;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $bt6;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $bt12;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lubs;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $cshop;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $contacts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getFramecode(): ?string
    {
        return $this->framecode;
    }

    public function setFramecode(?string $framecode): self
    {
        $this->framecode = $framecode;

        return $this;
    }

    public function getBt6(): ?string
    {
        return $this->bt6;
    }

    public function setBt6(?string $bt6): self
    {
        $this->bt6 = $bt6;

        return $this;
    }

    public function getBt12(): ?string
    {
        return $this->bt12;
    }

    public function setBt12(?string $bt12): self
    {
        $this->bt12 = $bt12;

        return $this;
    }

    public function getLubs(): ?string
    {
        return $this->lubs;
    }

    public function setLubs(?string $lubs): self
    {
        $this->lubs = $lubs;

        return $this;
    }

    public function getCshop(): ?string
    {
        return $this->cshop;
    }

    public function setCshop(?string $cshop): self
    {
        $this->cshop = $cshop;

        return $this;
    }

    public function getContacts(): ?string
    {
        return $this->contacts;
    }

    public function setContacts(?string $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }

}
