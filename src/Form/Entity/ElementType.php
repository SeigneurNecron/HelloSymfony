<?php

namespace App\Form\Entity;

use App\Entity\Final\Element;
use App\Form\Base\AbstractEntityType;
use App\Form\Field\NameAndSlugType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @template-extends AbstractEntityType<Element>
 */
class ElementType extends AbstractEntityType {

    public function __construct() {
        parent::__construct(Element::class);
    }

    protected function doBuildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add(
                'nameAndSlug', NameAndSlugType::class,
            )
            ->add(
                'color',
            );
    }

}
