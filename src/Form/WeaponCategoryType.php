<?php

namespace App\Form;

use App\Entity\WeaponCategory;
use App\Form\Base\AbstractEntityType;
use App\Form\Trait\WithName;
use App\Form\Trait\WithSubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeaponCategoryType extends AbstractEntityType {

    use WithName, WithSubmitButton;

    protected function doConfigureOptions(OptionsResolver $resolver): void {
        $resolver->setDefault('data_class', WeaponCategory::class);
    }

}
