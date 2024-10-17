<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterType;
use App\Repository\CharacterRepository;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/Character', name: 'Character_')]
class CharactersController extends AbstractCreatableEntityController {

    public function __construct(CharacterRepository $repository) {
        parent::__construct(Character::class, CharacterType::class, $repository);
    }

    protected function newEntity(): Character {
        return new Character();
    }

}
