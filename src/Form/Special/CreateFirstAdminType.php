<?php

namespace App\Form\Special;

use App\Form\Base\AbstractCustomType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateFirstAdminType extends AbstractCustomType {

    public function doBuildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('updateIfExists', CheckboxType::class, options: [
                'label' => "update if already exists",
                'required' => false
            ]);
    }

}