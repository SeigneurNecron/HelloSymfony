<?php

namespace App\Repository\Base;

use App\Entity\Base\AbstractNameableEntity;
use App\Enum\QueryMode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template E of AbstractNameableEntity
 * @extends ServiceEntityRepository<E>
 */
abstract class AbstractNameableEntityRepository extends ServiceEntityRepository {

    protected readonly string $entityClass;

    /**
     * @param ManagerRegistry $registry
     * @param class-string<E> $entityClass
     */
    public function __construct(ManagerRegistry $registry, string $entityClass) {
        parent::__construct($registry, $entityClass);
        $this->entityClass = $entityClass;
    }

    /**
     * @return E
     */
    protected function newEntity() {
        return new $this->entityClass();
    }

    /**
     * @param string $slug
     * @param QueryMode $queryMode
     * @return E|null
     */
    public abstract function findOneBySlug(string $slug, QueryMode $queryMode): ?AbstractNameableEntity;

}
