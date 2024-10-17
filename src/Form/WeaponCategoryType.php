<?php

namespace App\Form;

use App\Entity\WeaponCategory;
use App\Form\Base\AbstractEntityType;
use App\Form\Trait\WithName;
use App\Form\Trait\WithSubmitButton;

/**
 * @template-extends AbstractEntityType<WeaponCategory>
 */
class WeaponCategoryType extends AbstractEntityType {

    use WithName, WithSubmitButton;

    public function __construct() {
        parent::__construct(WeaponCategory::class);
    }

}
