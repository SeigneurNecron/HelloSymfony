<?php

namespace App\Form\Special;

use App\Entity\Final\User;
use App\Form\Base\AbstractCustomType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractCustomType {

    public function __construct(
        private readonly RouterInterface $router,
    ) {}

    public function doBuildForm(FormBuilderInterface $builder, array $options): void {
        $tosPath = $this->router->generate('Main_ToS');

        $builder
            ->add(
                'email', EmailType::class, options: [
                'help' => "A validation link will be sent to this address.",
            ],
            )
            ->add('username')
            ->add(
                'plainPassword', RepeatedType::class, options: [
                'type'            => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'mapped'          => false,
                'options'         => [
                    'toggle' => true,
                ],
                'first_options'   => [
                    'label'       => 'Password',
                    'attr'        => ['autocomplete' => 'new-password'],
                    'constraints' => [
                        new NotBlank(['message' => 'Please enter a password']),
                        new Length(
                            [
                                'min'        => 6,
                                'minMessage' => 'Your password should be at least {{ limit }} characters',
                                'max'        => 4096, // max length allowed by Symfony for security reasons
                            ],
                        ),
                    ],
                ],
                'second_options'  => [
                    'label' => 'Repeat Password',
                ],
            ],
            )
            ->add(
                'agreeTerms', CheckboxType::class, options: [
                'label'       => "I agree with the <a href=\"$tosPath\" title=\"terms and conditions\">terms and conditions</a>",
                'label_html'  => true,
                'mapped'      => false,
                'constraints' => [
                    new IsTrue(['message' => 'You should agree to our terms.']),
                ],
            ],
            );
    }

    public function doConfigureOptions(OptionsResolver $resolver): void {
        $resolver->setDefault('data_class', User::class);
        $resolver->setDefault('submitButtonLabel', 'Register');
    }

}
