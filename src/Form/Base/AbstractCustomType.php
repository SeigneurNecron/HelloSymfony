<?php

namespace App\Form\Base;

use App\Form\Attribute\BuildFormMethod;
use App\Form\Attribute\ConfigureOptionsMethod;
use App\Utils\Reflect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractCustomType extends AbstractType {

    public final function buildForm(FormBuilderInterface $builder, array $options): void {
        $buildMethods = Reflect::getMethodsAndAttribute($this, BuildFormMethod::class);
        $buildLaterMethods = [];

        foreach($buildMethods as $buildMethod => $attribute) {
            if($attribute->atTheEnd) {
                $buildLaterMethods[] = $buildMethod;
            }
            else {
                $this->$buildMethod($builder, $options);
            }
        }

        $this->doBuildForm($builder, $options);

        foreach($buildLaterMethods as $buildMethod) {
            $this->$buildMethod($builder, $options);
        }

        if($options['insertSubmitButton']) {
            $builder
                ->add('submitButton', SubmitType::class, options: [
                    'label' => $options['submitButtonLabel']
                ]);
        }
    }

    protected function doBuildForm(FormBuilderInterface $builder, array $options): void {
        // Allows child classes to build the form directly.
    }

    public final function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefault('insertSubmitButton', true);
        $resolver->setDefault('submitButtonLabel', 'Submit');

        $this->doConfigureOptions($resolver);

        $configureMethods = Reflect::getMethodsWithAttribute($this, ConfigureOptionsMethod::class);

        foreach($configureMethods as $configureMethod) {
            $this->$configureMethod($resolver);
        }
    }

    protected function doConfigureOptions(OptionsResolver $resolver): void {
        // Allows child classes to configure options directly.
    }

}