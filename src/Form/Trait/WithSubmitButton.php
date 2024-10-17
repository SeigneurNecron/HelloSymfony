<?php

namespace App\Form\Trait;

use App\Form\Attribute\BuildFormMethod;
use App\Form\Attribute\ConfigureOptionsMethod;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

trait WithSubmitButton {

    #[BuildFormMethod(atTheEnd: true)]
    protected function buildFormWithSubmitButton(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('submitButton', SubmitType::class, ['label' => $options['submitButtonLabel']]);
    }

    #[ConfigureOptionsMethod]
    protected function configureOptionsWithSubmitButton(OptionsResolver $resolver): void {
        $resolver->setDefault('submitButtonLabel', 'Validate');
    }

}
