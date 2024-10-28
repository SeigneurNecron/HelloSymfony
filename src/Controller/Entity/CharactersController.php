<?php

declare(strict_types = 1);

namespace App\Controller\Entity;

use App\Controller\Base\AbstractCreatableEntityController;
use App\Entity\Final\Character;
use App\Form\Entity\CharacterType;
use App\Repository\Final\CharacterRepository;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/Character', name: 'Character_')]
class CharactersController extends AbstractCreatableEntityController {

    public function __construct(CharacterRepository $repository) {
        parent::__construct(Character::class, CharacterType::class, $repository);
    }

}
