<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Controller\Base\AbstractCreatableEntityController;
use App\Entity\WeaponCategory;
use App\Form\WeaponCategoryType;
use App\Repository\WeaponCategoryRepository;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/WeaponCategory', name: 'WeaponCategory_')]
class WeaponCategoryController extends AbstractCreatableEntityController {

    public function __construct(WeaponCategoryRepository $repository) {
        parent::__construct(WeaponCategory::class, WeaponCategoryType::class, $repository);
    }

}
