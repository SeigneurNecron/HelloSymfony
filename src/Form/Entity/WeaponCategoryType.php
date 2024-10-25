<?php

namespace App\Form\Entity;

use App\Entity\WeaponCategory;
use App\Form\Base\AbstractEntityType;
use App\Form\Trait\WithName;

/**
 * @template-extends AbstractEntityType<WeaponCategory>
 */
class WeaponCategoryType extends AbstractEntityType {

    use WithName;

    public function __construct() {
        parent::__construct(WeaponCategory::class);
    }

}
