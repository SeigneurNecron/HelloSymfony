<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;

class LogInType extends AbstractType {

    public final function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('confirm', CheckboxType::class, options: [
                'constraints' => [
                    new IsTrue(['message' => "You need to confirm the deletion to proceed."
                    ]),
                ],
            ])
            ->add('submitButton', SubmitType::class, options: [
                'label' => "Log In",
            ]);
    }

}
