<?php

namespace App\Entity;

use App\Entity\Base\AbstractNamedEntity;
use App\Enum\Genre;
use App\Enum\Size;
use App\Repository\CharacterRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character extends AbstractNamedEntity {

    #[ORM\Column]
    #[Assert\Type('bool')]
    #[Assert\NotNull(message: "Please indicate if the character is rare.")]
    private ?bool $rare = null;

    #[ORM\Column(enumType: Genre::class)]
    #[Assert\NotBlank(message: "Please select the character's genre.")]
    private ?Genre $genre = null;

    #[ORM\Column(enumType: Size::class)]
    #[Assert\NotBlank(message: "Please select the character's size.")]
    private ?Size $size = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Please select the character's element.")]
    private ?Element $element = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Please select the character's weapon category.")]
    private ?WeaponCategory $weaponCategory = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Please select the character's region.")]
    private ?Region $region = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter the game version during which the character was released.")]
    #[Assert\Regex(pattern: "/^\d+.\d+$/", message: "Version number should look like this: X.Y (with X and Y being integers)")]
    private ?string $version = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotBlank(message: "Please enter the character's release date.")]
    private ?DateTimeImmutable $releaseDate = null;

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

    public function getReleaseDate(): ?DateTimeImmutable {
        return $this->releaseDate;
    }

    public function setReleaseDate(DateTimeImmutable $releaseDate): static {
        $this->releaseDate = $releaseDate;

        return $this;
    }

}
