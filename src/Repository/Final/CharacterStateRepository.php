<?php

namespace App\Repository\Final;

use App\Entity\Base\AbstractNameableEntity;
use App\Entity\Final\CharacterState;
use App\Enum\QueryMode;
use App\Repository\Base\AbstractNameableEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException;

/**
 * @template-extends AbstractNameableEntityRepository<CharacterState>
 */
class CharacterStateRepository extends AbstractNameableEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, CharacterState::class);
    }

    public function findOneBySlug(string $slug, QueryMode $queryMode): ?AbstractNameableEntity {
        // TODO: Implement findOneBySlug() method.
        throw new NotImplementedException("Implement CharacterStateRepository.findOneBySlug");
    }

}
