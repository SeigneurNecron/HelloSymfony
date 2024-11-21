<?php

namespace App\Entity\Final;

use App\Entity\Base\AbstractNamedEntity;
use App\Entity\Base\AdminEntityCUD;
use App\Repository\Final\ArtifactSetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtifactSetRepository::class)]
class ArtifactSet extends AbstractNamedEntity implements AdminEntityCUD {}
