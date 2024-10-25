<?php

namespace App\Form\Entity;

use App\Entity\Element;
use App\Form\Base\AbstractEntityType;
use App\Form\Trait\WithName;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @template-extends AbstractEntityType<Element>
 */
class ElementType extends AbstractEntityType {

    use WithName;

    public function __construct() {
        parent::__construct(Element::class);
    }

    protected function doBuildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('color');
    }

}
