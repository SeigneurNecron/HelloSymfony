<?php

namespace App\Form;

use App\Entity\Region;
use App\Form\Base\AbstractEntityType;
use App\Form\Trait\WithName;
use App\Form\Trait\WithSubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegionType extends AbstractEntityType {

    use WithName, WithSubmitButton;

    protected function doConfigureOptions(OptionsResolver $resolver): void {
        $resolver->setDefault('data_class', Region::class);
    }

}
