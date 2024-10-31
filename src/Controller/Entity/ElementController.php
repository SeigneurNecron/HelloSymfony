<?php

declare(strict_types = 1);

namespace App\Controller\Entity;

use App\Controller\Base\AbstractCreatableNameableEntityController;
use App\Form\Entity\ElementType;
use App\Service\Entity\Final\ElementManager;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @template-extends AbstractCreatableNameableEntityController<Element>
 */
#[Route('/Element', name: 'Element_')]
class ElementController extends AbstractCreatableNameableEntityController {

    public function __construct(ElementManager $manager) {
        parent::__construct($manager, ElementType::class);
    }

}
