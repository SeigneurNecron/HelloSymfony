<?php

namespace App\Entity;

use App\Repository\ElementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
class Element {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Please provide a name")]
    #[Assert\Length(max: 255, maxMessage: "That name is too long")]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[Assert\NotBlank(message: "Please provide a color")]
    #[Assert\Length(max: 255, maxMessage: "That color is too long")]
    #[ORM\Column(length: 255)]
    private ?string $color = null;

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

    public function getColor(): ?string {
        return $this->color;
    }

    public function setColor(string $color): static {
        $this->color = trim($color);

        return $this;
    }

}
