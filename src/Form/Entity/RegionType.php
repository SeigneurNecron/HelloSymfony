<?php

namespace App\Form\Entity;

use App\Entity\Final\Region;
use App\Form\Base\AbstractEntityType;
use App\Form\Field\NameAndSlugType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @template-extends AbstractEntityType<Region>
 */
class RegionType extends AbstractEntityType {

    public function __construct() {
        parent::__construct(Region::class);
    }

    protected function doBuildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add(
                'nameAndSlug', NameAndSlugType::class,
            );
    }

}
