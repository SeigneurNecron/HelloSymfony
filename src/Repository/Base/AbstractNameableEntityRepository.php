<?php

namespace App\Repository\Base;

use App\Entity\Base\AbstractNameableEntity;
use App\Enum\QueryMode;

/**
 * @template E of AbstractNameableEntity
 * @template-extends AbstractEntityRepository<E>
 */
abstract class AbstractNameableEntityRepository extends AbstractEntityRepository {

    /**
     * @param string    $slug
     * @param QueryMode $queryMode
     *
     * @return E|null
     */
    public abstract function findOneBySlug(string $slug, QueryMode $queryMode): ?AbstractNameableEntity;

}
