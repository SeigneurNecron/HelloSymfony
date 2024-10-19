<?php

namespace App\Entity\Trait;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait WithTimeStamps {

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\NotBlank(message: "Creation date is missing.")]
    private ?DateTimeImmutable $dateCreated = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\NotBlank(message: "Last modification date is missing.")]
    private ?DateTimeImmutable $dateModified = null;

    public function getDateCreated(): ?DateTimeImmutable {
        return $this->dateCreated;
    }

    public function setDateCreated(DateTimeImmutable $dateCreated): static {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?DateTimeImmutable {
        return $this->dateModified;
    }

    public function setDateModified(DateTimeImmutable $dateModified): static {
        $this->dateModified = $dateModified;

        return $this;
    }

}
