<?php

namespace App\Form\Base;

use App\Form\Attribute\BuildFormMethod;
use App\Form\Attribute\ConfigureOptionsMethod;
use ReflectionObject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractEntityType extends AbstractType {

    public final function buildForm(FormBuilderInterface $builder, array $options): void {
        $buildFirstMethods = [];
        $buildLastMethods = [];

        $reflection = new ReflectionObject($this);

        foreach($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes(BuildFormMethod::class);

            if(count($attributes) > 0) {
                if($attributes[0]->newInstance()->atTheEnd) {
                    $buildLastMethods[] = $method->getName();
                }
                else {
                    $buildFirstMethods[] = $method->getName();
                }
            }
        }

        foreach($buildFirstMethods as $buildMethod) {
            $this->$buildMethod($builder, $options);
        }

        $this->doBuildForm($builder, $options);

        foreach($buildLastMethods as $buildMethod) {
            $this->$buildMethod($builder, $options);
        }
    }

    protected function doBuildForm(FormBuilderInterface $builder, array $options): void {
        // Allows child classes to build the form directly.
    }

    public final function configureOptions(OptionsResolver $resolver): void {
        $reflection = new ReflectionObject($this);

        foreach($reflection->getMethods() as $method) {
            if(count($method->getAttributes(ConfigureOptionsMethod::class)) > 0) {
                $methodName = $method->getName();
                $this->$methodName($resolver);
            }
        }

        $this->doConfigureOptions($resolver);
    }

    protected function doConfigureOptions(OptionsResolver $resolver): void {
        // Allows child classes to configure options directly.
    }

}