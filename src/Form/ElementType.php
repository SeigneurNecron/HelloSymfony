<?php

namespace App\Form;

use App\Entity\Element;
use App\Form\Base\AbstractEntityType;
use App\Form\Trait\WithName;
use App\Form\Trait\WithSubmitButton;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementType extends AbstractEntityType {

    use WithName, WithSubmitButton;

    protected function doBuildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('color');
    }

    protected function doConfigureOptions(OptionsResolver $resolver): void {
        $resolver->setDefault('data_class', Element::class);
    }

}
