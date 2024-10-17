<?php

namespace App\Repository;

use App\Entity\WeaponCategory;
use App\Repository\Base\AbstractEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractEntityRepository<WeaponCategory>
 */
class WeaponCategoryRepository extends AbstractEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, WeaponCategory::class);
    }

}
