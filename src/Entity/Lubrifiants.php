<?php

namespace App\Entity;

use App\Repository\LubrifiantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LubrifiantsRepository::class)
 */
class Lubrifiants
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $lub_name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lub_description;

    /**
     * @ORM\OneToMany(targetEntity=Declinaisons::class, mappedBy="fk_lubrifiant")
     */
    private $declinaisons;

    public function __construct()
    {
        $this->declinaisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLubName(): ?string
    {
        return $this->lub_name;
    }

    public function setLubName(string $lub_name): self
    {
        $this->lub_name = $lub_name;

        return $this;
    }

    public function getLubDescription(): ?string
    {
        return $this->lub_description;
    }

    public function setLubDescription(?string $lub_description): self
    {
        $this->lub_description = $lub_description;

        return $this;
    }

    /**
     * @return Collection<int, Declinaisons>
     */
    public function getDeclinaisons(): Collection
    {
        return $this->declinaisons;
    }

    public function addDeclinaison(Declinaisons $declinaison): self
    {
        if (!$this->declinaisons->contains($declinaison)) {
            $this->declinaisons[] = $declinaison;
            $declinaison->setFkLubrifiant($this);
        }

        return $this;
    }

    public function removeDeclinaison(Declinaisons $declinaison): self
    {
        if ($this->declinaisons->removeElement($declinaison)) {
            // set the owning side to null (unless already changed)
            if ($declinaison->getFkLubrifiant() === $this) {
                $declinaison->setFkLubrifiant(null);
            }
        }

        return $this;
    }
}
