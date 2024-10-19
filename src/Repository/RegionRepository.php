<?php

namespace App\Repository;

use App\Entity\Region;
use App\Repository\Base\AbstractNamedEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractNamedEntityRepository<Region>
 */
class RegionRepository extends AbstractNamedEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Region::class);
    }

}
