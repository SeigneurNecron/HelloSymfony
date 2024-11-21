<?php

namespace App\Entity\Final;

use App\Entity\Base\AbstractNamedEntity;
use App\Entity\Base\AdminEntityCUD;
use App\Repository\Final\ArtifactSetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtifactSetRepository::class)]
class ArtifactSet extends AbstractNamedEntity implements AdminEntityCUD {

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): static {
        $this->description = $description;

        return $this;
    }

}
