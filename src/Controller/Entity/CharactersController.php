<?php

declare(strict_types = 1);

namespace App\Controller\Entity;

use App\Controller\Base\AbstractCreatableNameableEntityController;
use App\Form\Entity\CharacterType;
use App\Service\Entity\Final\CharacterManager;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @template-extends AbstractCreatableNameableEntityController<Character>
 */
#[Route(path: '/Character', name: 'Character_')]
class CharactersController extends AbstractCreatableNameableEntityController {

    public function __construct(CharacterManager $manager) {
        parent::__construct($manager, CharacterType::class);
    }

}
