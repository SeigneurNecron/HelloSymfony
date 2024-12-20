<?php

namespace App\Service\Entity\Base;

use App\Entity\Base\AbstractNameableEntity;
use App\Enum\QueryMode;
use App\Repository\Base\AbstractNameableEntityRepository;

/**
 * @template E of AbstractNameableEntity
 * @template R of AbstractNameableEntityRepository<E>
 * @template-extends AbstractEntityManager<E, R>
 */
abstract readonly class AbstractNameableEntityManager extends AbstractEntityManager {

    /**
     * @return array<E>
     */
    public function findAll(): array {
        return $this->repository->findBy([], ['name' => 'ASC']);
    }

    /**
     * @param string    $slug
     * @param QueryMode $queryMode
     *
     * @return E|null
     */
    public function findOneBySlug(string $slug, QueryMode $queryMode): ?AbstractNameableEntity {
        return $this->repository->findOneBySlug($slug, $queryMode);
    }

}
