<?php

namespace App\Entity;

use App\Repository\WeaponCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeaponCategoryRepository::class)]
class WeaponCategory extends AbstractNamedEntity {

}
