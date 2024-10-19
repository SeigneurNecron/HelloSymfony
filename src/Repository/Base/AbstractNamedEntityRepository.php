<?php

namespace App\Repository\Base;

use App\Entity\Base\AbstractNamedEntity;

/**
 * @template E of AbstractNamedEntity
 * @template-extends AbstractNameableEntityRepository<E>
 */
abstract class AbstractNamedEntityRepository extends AbstractNameableEntityRepository {

    /**
     * @param string $slug
     * @return E|null
     */
    public function findOneBySlug(string $slug): ?AbstractNamedEntity {
        return $this->createQueryBuilder('e')
            ->andWhere('e.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

}