<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterType;
use App\Repository\CharacterRepository;
use DateTime;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/Character', name: 'Character_')]
class CharactersController extends AbstractEntityController {

    public function __construct(CharacterRepository $repository) {
        parent::__construct(Character::class, CharacterType::class, $repository);
    }

    protected function newEntity(): Character {
        return new Character();
    }

    protected function onCreateSubmission(object $entity): void {
        $entity->setDateCreated(new DateTime());
        $entity->setDateModified(new DateTime());
    }

    protected function onEditSubmission(object $entity): void {
        $entity->setDateModified(new DateTime());
    }

}
