<?php

namespace App\Repository\Base;

use App\Entity\Base\AbstractNamedEntity;
use App\Enum\QueryMode;
use App\Utils\Reflect;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @template E of AbstractNamedEntity
 * @template-extends AbstractNameableEntityRepository<E>
 */
abstract class AbstractNamedEntityRepository extends AbstractNameableEntityRepository {

    /**
     * @param string $slug
     * @param QueryMode $queryMode
     * @return E|null
     */
    public function findOneBySlug(string $slug, QueryMode $queryMode): ?AbstractNamedEntity {
        $builder = $this->createQueryBuilder('entity')
            ->andWhere('entity.slug = :slug')
            ->setParameter('slug', $slug);

        if($queryMode !== QueryMode::Simple) {
            $attributeClass = ($queryMode === QueryMode::WithChildren) ? ManyToOne::class : OneToMany::class;
            $fields = Reflect::getFieldsWithAttribute($this->newEntity(), $attributeClass);

            foreach($fields as $field) {
                $builder->leftJoin("entity.$field", $field);
                $builder->addSelect("$field");
            }
        }

        return $builder->getQuery()->getOneOrNullResult();
    }

}
