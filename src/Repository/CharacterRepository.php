<?php

namespace App\Repository;

use App\Entity\Character;
use App\Repository\Base\AbstractEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractEntityRepository<Character>
 */
class CharacterRepository extends AbstractEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Character::class);
    }

}
