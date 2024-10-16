<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('name', message: "This name is already in use")]
abstract class AbstractNamedEntity extends AbstractNameableEntity {

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: "Please provide a name")]
    #[Assert\Length(max: 255, maxMessage: "That name is too long")]
    protected ?string $name = null;

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = trim($name);

        return $this;
    }

}