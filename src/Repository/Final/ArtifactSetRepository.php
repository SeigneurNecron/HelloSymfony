<?php

namespace App\Repository\Final;

use App\Entity\Final\ArtifactSet;
use App\Repository\Base\AbstractNamedEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends AbstractNamedEntityRepository<ArtifactSet>
 */
class ArtifactSetRepository extends AbstractNamedEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ArtifactSet::class);
    }

}
