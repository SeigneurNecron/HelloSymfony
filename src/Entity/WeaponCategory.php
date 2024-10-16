<?php

namespace App\Entity;

use App\Repository\WeaponCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WeaponCategoryRepository::class)]
class WeaponCategory {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Please provide a name")]
    #[Assert\Length(max: 255, maxMessage: "That name is too long")]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = trim($name);

        return $this;
    }

}
