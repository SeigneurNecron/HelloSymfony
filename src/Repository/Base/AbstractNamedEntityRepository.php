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
     * @param bool $withDetails
     * @return E|null
     */
    public function findOneBySlug(string $slug, bool $withDetails): ?AbstractNamedEntity {
        $builder = $this->createQueryBuilder('entity');

        $builder->andWhere('entity.slug = :slug')
            ->setParameter('slug', $slug);

        if($withDetails) {
            // TODO - pull referenced entities names and slugs at once.
        }

        return $builder->getQuery()->getOneOrNullResult();
    }

}