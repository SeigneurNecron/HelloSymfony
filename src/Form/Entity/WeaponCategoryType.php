<?php

namespace App\Form\Entity;

use App\Entity\Final\WeaponCategory;
use App\Form\Base\AbstractEntityType;
use App\Form\Field\NameAndSlugType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @template-extends AbstractEntityType<WeaponCategory>
 */
class WeaponCategoryType extends AbstractEntityType {

    public function __construct() {
        parent::__construct(WeaponCategory::class);
    }

    protected function doBuildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add(
                'nameAndSlug', NameAndSlugType::class,
            );
    }

}
