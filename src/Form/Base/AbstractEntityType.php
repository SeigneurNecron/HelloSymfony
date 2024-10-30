<?php

namespace App\Form\Base;

use App\Entity\Base\AbstractEntity;
use App\Form\Attribute\BuildFormMethod;
use App\Form\Attribute\ConfigureOptionsMethod;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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

    #[BuildFormMethod]
    protected function buildFormOfAbstractEntity(FormBuilderInterface $builder, array $options): void {
        $builder->addEventListener(
            FormEvents::SUBMIT, function(FormEvent $event) {
            $data = $event->getData();

            if($data instanceof AbstractEntity) {
                $data->preValidate();
            }
        },
        );
    }

    #[ConfigureOptionsMethod]
    protected function configureOptionsEntity(OptionsResolver $resolver): void {
        $resolver->setDefault('data_class', $this->entityClass);
    }

}
