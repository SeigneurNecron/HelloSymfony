<?php

namespace App\Repository\Base;

use App\Entity\Base\AbstractNamedEntity;
use App\Enum\QueryMode;

/**
 * @template E of AbstractNamedEntity
 * @template-extends AbstractNameableEntityRepository<E>
 */
abstract class AbstractNamedEntityRepository extends AbstractNameableEntityRepository {

    /**
     * @param string    $slug
     * @param QueryMode $queryMode
     *
     * @return E|null
     */
    public function findOneBySlug(string $slug, QueryMode $queryMode): ?AbstractNamedEntity {
        $builder = $this->createQueryBuilder('entity')
                        ->andWhere('entity.slug = :slug')
                        ->setParameter('slug', $slug);

        if($queryMode !== QueryMode::Simple) {
            $entity = $this->newEntity();
            $fields = ($queryMode === QueryMode::WithChildren) ? $entity->getChildFields() : $entity->getParentFields();

            foreach($fields as $field => $attribute) {
                $builder->leftJoin("entity.$field", $field);
                $builder->addSelect("$field");
            }
        }

        return $builder->getQuery()->getOneOrNullResult();
    }

}
