<?php

declare(strict_types = 1);

namespace App\Controller\Entity;

use App\Controller\Base\AbstractCreatableNameableEntityController;
use App\Form\Entity\WeaponCategoryType;
use App\Service\Entity\Final\WeaponCategoryManager;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @template-extends AbstractCreatableNameableEntityController<WeaponCategory>
 */
#[Route('/WeaponCategory', name: 'WeaponCategory_')]
class WeaponCategoryController extends AbstractCreatableNameableEntityController {

    public function __construct(WeaponCategoryManager $manager) {
        parent::__construct($manager, WeaponCategoryType::class);
    }

}
