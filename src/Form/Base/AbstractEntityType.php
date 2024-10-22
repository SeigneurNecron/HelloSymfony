<?php

namespace App\Form\Base;

use App\Entity\Base\AbstractEntity;
use App\Form\Attribute\BuildFormMethod;
use App\Form\Attribute\ConfigureOptionsMethod;
use App\Utils\Reflect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @template E of AbstractEntity
 */
abstract class AbstractEntityType extends AbstractType {

    /**
     * @param class-string<E> $entityClass
     */
    protected function __construct(
        protected readonly string $entityClass
    ) {}

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
    }

    protected function doBuildForm(FormBuilderInterface $builder, array $options): void {
        // Allows child classes to build the form directly.
    }

    public final function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefault('data_class', $this->entityClass);

        $configureMethods = Reflect::getMethodsWithAttribute($this, ConfigureOptionsMethod::class);

        foreach($configureMethods as $configureMethod) {
            $this->$configureMethod($resolver);
        }

        $this->doConfigureOptions($resolver);
    }

    protected function doConfigureOptions(OptionsResolver $resolver): void {
        // Allows child classes to configure options directly.
    }

}