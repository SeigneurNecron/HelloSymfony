<?php

namespace App\Repository;

use App\Entity\Element;
use App\Repository\Base\AbstractEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractEntityRepository<Element>
 */
class ElementRepository extends AbstractEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Element::class);
    }

}
