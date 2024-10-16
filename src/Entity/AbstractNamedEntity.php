<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractNamedEntity extends AbstractNameableEntity {

    #[Assert\NotBlank(message: "Please provide a name")]
    #[Assert\Length(max: 255, maxMessage: "That name is too long")]
    #[ORM\Column(length: 255, unique: true)]
    protected ?string $name = null;

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = trim($name);

        return $this;
    }

}