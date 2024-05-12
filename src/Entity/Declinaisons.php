<?php

namespace App\Entity;

use App\Repository\DeclinaisonsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeclinaisonsRepository::class)
 */
class Declinaisons
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $grade;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $performance;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $emballage;

    /**
     * @ORM\ManyToOne(targetEntity=Lubrifiants::class, inversedBy="declinaisons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_lubrifiant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fichetechnique;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $apercu;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(?string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getPerformance(): ?string
    {
        return $this->performance;
    }

    public function setPerformance(?string $performance): self
    {
        $this->performance = $performance;

        return $this;
    }

    public function getEmballage(): ?string
    {
        return $this->emballage;
    }

    public function setEmballage(?string $emballage): self
    {
        $this->emballage = $emballage;

        return $this;
    }

    public function getFkLubrifiant(): ?lubrifiants
    {
        return $this->fk_lubrifiant;
    }

    public function setFkLubrifiant(?lubrifiants $fk_lubrifiant): self
    {
        $this->fk_lubrifiant = $fk_lubrifiant;

        return $this;
    }

    public function getFichetechnique(): ?string
    {
        return $this->fichetechnique;
    }

    public function setFichetechnique(?string $fichetechnique): self
    {
        $this->fichetechnique = $fichetechnique;

        return $this;
    }

    public function getApercu(): ?string
    {
        return $this->apercu;
    }

    public function setApercu(?string $apercu): self
    {
        $this->apercu = $apercu;

        return $this;
    }
}
