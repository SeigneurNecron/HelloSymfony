<?php

namespace App\Form\Field;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NameAndSlugType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add(
                'name', options: [
                'attr' => ['autofocus' => true],
            ],
            )
            ->add(
                'customSlug', CheckboxType::class, options: [
                'mapped'   => false,
                'required' => false,
                'attr'     => [
                    'data-optional-field-target' => 'checkbox',
                    'data-action'                => 'optional-field#onToggle',
                ],
            ],
            )
            ->add(
                'slug', options: [
                'required' => false,
                'help'     => "Will be auto-generated from Name if left empty. Used to make pretty URLs.",
                'row_attr' => [
                    'data-optional-field-target' => 'row',
                ],
                'attr'     => [
                    'data-optional-field-target' => 'field',
                ],
            ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults(
            [
                'label'        => false,
                'inherit_data' => true,
                'attr'         => [
                    'data-controller' => 'optional-field',
                    'data-action'     => 'form-manager:submit@window->optional-field#submit',
                ],
            ],
        );
    }

}
