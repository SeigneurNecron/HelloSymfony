<?php

namespace App\Repository\Base;

use App\Entity\Base\AbstractEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template E of AbstractEntity
 * @template-extends ServiceEntityRepository<E>
 */
abstract class AbstractEntityRepository extends ServiceEntityRepository {

    /**
     * @param ManagerRegistry $registry
     * @param class-string<E> $entityClass
     */
    public function __construct(
        ManagerRegistry           $registry,
        protected readonly string $entityClass,
    ) {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @return E
     */
    protected function newEntity() {
        return new $this->entityClass();
    }

}
