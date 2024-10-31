<?php

namespace App\Form\Base;

use App\Entity\Base\AbstractEntity;
use App\Form\Attribute\ConfigureOptionsMethod;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @template E of AbstractEntity
 */
abstract class AbstractEntityType extends AbstractCustomType {

    /**
     * @param class-string<E> $entityClass
     */
    protected function __construct(
        protected readonly string $entityClass,
    ) {}

    #[ConfigureOptionsMethod]
    protected function configureOptionsEntity(OptionsResolver $resolver): void {
        $resolver->setDefault('data_class', $this->entityClass);
    }

}
