<?php

declare(strict_types = 1);

namespace App\Controller\Entity;

use App\Controller\Base\AbstractCreatableEntityController;
use App\Entity\Final\WeaponCategory;
use App\Form\Entity\WeaponCategoryType;
use App\Repository\Final\WeaponCategoryRepository;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/WeaponCategory', name: 'WeaponCategory_')]
class WeaponCategoryController extends AbstractCreatableEntityController {

    public function __construct(WeaponCategoryRepository $repository) {
        parent::__construct(WeaponCategory::class, WeaponCategoryType::class, $repository);
    }

}
