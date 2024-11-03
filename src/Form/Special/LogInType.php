<?php

namespace App\Form\Special;

use App\Form\Base\AbstractCustomType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogInType extends AbstractCustomType {

    public final function doBuildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add(
                'username', TextType::class, options: [
                'label' => "Username or email",
                'attr'  => [
                    'autofocus'    => true,
                    'autocomplete' => 'username',
                    'value'        => $options['lastUsername'],
                ],
            ],
            )
            ->add(
                'password', PasswordType::class, options: [
                'label'  => "Password",
                'toggle' => true,
                'attr'   => [
                    'autocomplete' => 'current-password',
                ],
            ],
            )
            ->add(
                'remember_me', CheckboxType::class, options: [
                'label'    => 'Remember me',
                'required' => false,
            ],
            );
    }

    public function doConfigureOptions(OptionsResolver $resolver): void {
        $resolver->setDefault('submitButtonLabel', 'Sign in');
        $resolver->setDefault('lastUsername', '');
    }

}
