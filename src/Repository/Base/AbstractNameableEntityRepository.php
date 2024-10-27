<?php

namespace App\Repository\Base;

use App\Entity\Base\AbstractNameableEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template E of AbstractNameableEntity
 * @extends ServiceEntityRepository<E>
 */
abstract class AbstractNameableEntityRepository extends ServiceEntityRepository {

    /**
     * @param ManagerRegistry $registry
     * @param class-string<E> $entityClass
     */
    public function __construct(ManagerRegistry $registry, string $entityClass) {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @param string $slug
     * @param bool $withDetails
     * @return E|null
     */
    public abstract function findOneBySlug(string $slug, bool $withDetails): ?AbstractNameableEntity;

}