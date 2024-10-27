<?php

namespace App\Repository\Base;

use App\Entity\Base\AbstractNamedEntity;
use App\Utils\Reflect;
use Doctrine\ORM\Mapping\ManyToOne;

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
        $builder = $this->createQueryBuilder('entity')
            ->andWhere('entity.slug = :slug')
            ->setParameter('slug', $slug);

        if($withDetails) {
            $fields = Reflect::getFieldsWithAttribute($this->newEntity(), ManyToOne::class);

            foreach($fields as $field) {
                $builder->leftJoin("entity.$field", $field);
                $builder->addSelect("$field");
            }
        }

        return $builder->getQuery()->getOneOrNullResult();
    }

}
