<?php

namespace App\Repository;

use App\Entity\Element;
use App\Repository\Base\AbstractNamedEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractNamedEntityRepository<Element>
 */
class ElementRepository extends AbstractNamedEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Element::class);
    }

}
