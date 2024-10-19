<?php

namespace App\Repository;

use App\Entity\WeaponCategory;
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
