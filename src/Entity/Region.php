<?php

namespace App\Entity;

use App\Entity\Base\AbstractNamedEntity;
use App\Repository\RegionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region extends AbstractNamedEntity {

}
