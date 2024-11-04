<?php

namespace App\Service\Entity\Final;

use App\Entity\Final\Character;
use App\Repository\Final\CharacterRepository;
use App\Service\Entity\Base\AbstractNamedEntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template-extends AbstractNamedEntityManager<Character, CharacterRepository>
 */
readonly class CharacterManager extends AbstractNamedEntityManager {

    public function __construct(
        CharacterRepository    $repository,
        EntityManagerInterface $entityManager,
        ValidatorInterface     $validator,
    ) {
        parent::__construct(
            Character::class,
            $repository,
            $entityManager,
            $validator,
        );
    }

}
