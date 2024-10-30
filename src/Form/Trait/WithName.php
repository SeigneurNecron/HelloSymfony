<?php

namespace App\Form\Trait;

use App\Form\Attribute\BuildFormMethod;
use Symfony\Component\Form\FormBuilderInterface;

trait WithName {

    #[BuildFormMethod]
    protected function buildFormWithName(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add(
                'name', options: [
                'attr' => ['autofocus' => true],
            ],
            )
            ->add(
                'slug', options: [
                'required' => false,
                'help'     => "Will be auto-generated from Name if left empty. Used to make pretty URLs.",
            ],
            );
    }

}
