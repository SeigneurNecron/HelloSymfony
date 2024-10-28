<?php

namespace App\Repository\Final;

use App\Entity\Final\WeaponCategory;
use App\Repository\Base\AbstractNamedEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractNamedEntityRepository<WeaponCategory>
 */
class WeaponCategoryRepository extends AbstractNamedEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, WeaponCategory::class);
    }

}
