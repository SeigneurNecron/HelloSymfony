<?php

namespace App\Entity;

use App\Repository\ElementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
class Element extends AbstractNamedEntity {

    #[Assert\NotBlank(message: "Please provide a color")]
    #[Assert\Length(max: 255, maxMessage: "That color is too long")]
    #[ORM\Column(length: 255)]
    private ?string $color = null;

    public function getColor(): ?string {
        return $this->color;
    }

    public function setColor(string $color): static {
        $this->color = trim($color);

        return $this;
    }

}
