<?php

namespace App\Repository;

use App\Entity\Region;
use App\Repository\Base\AbstractEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractEntityRepository<Region>
 */
class RegionRepository extends AbstractEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Region::class);
    }

}
