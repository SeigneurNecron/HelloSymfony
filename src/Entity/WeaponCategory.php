<?php

namespace App\Entity;

use App\Entity\Base\AbstractNamedEntity;
use App\Repository\WeaponCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeaponCategoryRepository::class)]
class WeaponCategory extends AbstractNamedEntity {

}
