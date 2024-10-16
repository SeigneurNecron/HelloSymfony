<?php

namespace App\Entity;

use App\Enum\Genre;
use App\Enum\Size;
use App\Repository\CharacterRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character extends AbstractNamedEntity {

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\NotBlank]
    private ?DateTimeInterface $dateCreated = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\NotBlank]
    private ?DateTimeInterface $dateModified = null;

    #[ORM\Column/*(options: ["default" => false])*/]
    private ?bool $rare = null;

    #[ORM\Column(enumType: Genre::class)]
    private ?Genre $genre = null;

    #[ORM\Column(enumType: Size::class)]
    private ?Size $size = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Element $element = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?WeaponCategory $weaponCategory = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Region $region = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 1)]
    private ?string $version = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeInterface $releaseDate = null;

    public function getDateCreated(): ?DateTimeInterface {
        return $this->dateCreated;
    }

    public function setDateCreated(DateTimeInterface $dateCreated): static {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?DateTimeInterface {
        return $this->dateModified;
    }

    public function setDateModified(?DateTimeInterface $dateModified): static {
        $this->dateModified = $dateModified;

        return $this;
    }

    public function isRare(): ?bool {
        return $this->rare;
    }

    public function setRare(bool $rare): static {
        $this->rare = $rare;

        return $this;
    }

    public function getGenre(): ?Genre {
        return $this->genre;
    }

    public function setGenre(Genre $genre): static {
        $this->genre = $genre;

        return $this;
    }

    public function getSize(): ?Size {
        return $this->size;
    }

    public function setSize(Size $size): static {
        $this->size = $size;

        return $this;
    }

    public function getElement(): ?Element {
        return $this->element;
    }

    public function setElement(?Element $element): static {
        $this->element = $element;

        return $this;
    }

    public function getWeaponCategory(): ?WeaponCategory {
        return $this->weaponCategory;
    }

    public function setWeaponCategory(?WeaponCategory $weaponCategory): static {
        $this->weaponCategory = $weaponCategory;

        return $this;
    }

    public function getRegion(): ?Region {
        return $this->region;
    }

    public function setRegion(?Region $region): static {
        $this->region = $region;

        return $this;
    }

    public function getVersion(): ?string {
        return $this->version;
    }

    public function setVersion(string $version): static {
        $this->version = $version;

        return $this;
    }

    public function getReleaseDate(): ?DateTimeInterface {
        return $this->releaseDate;
    }

    public function setReleaseDate(DateTimeInterface $releaseDate): static {
        $this->releaseDate = $releaseDate;

        return $this;
    }

}
