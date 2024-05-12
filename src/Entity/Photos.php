<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotosRepository::class)
 */
class Photos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagename;

    /**
     * @ORM\ManyToOne(targetEntity=albums::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_albums;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagename(): ?string
    {
        return $this->imagename;
    }

    public function setImagename(string $imagename): self
    {
        $this->imagename = $imagename;

        return $this;
    }

    public function getFkAlbums(): ?albums
    {
        return $this->fk_albums;
    }

    public function setFkAlbums(?albums $fk_albums): self
    {
        $this->fk_albums = $fk_albums;

        return $this;
    }
}
