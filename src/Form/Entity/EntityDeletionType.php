<?php

namespace App\Form\Entity;

use App\Form\Base\AbstractCustomType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class EntityDeletionType extends AbstractCustomType {

    public function doBuildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add(
                'confirm', CheckboxType::class, options: [
                'constraints' => [
                    new IsTrue(
                        [
                            'message' => "You need to confirm the deletion to proceed.",
                        ],
                    ),
                ],
            ],
            );
    }

    public function doConfigureOptions(OptionsResolver $resolver): void {
        $resolver->setDefault('submitButtonLabel', 'Delete');
    }

}
