<?php

namespace App\Form\Special;

use App\Form\Base\AbstractCustomType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SendVerificationMailType extends AbstractCustomType {

    public function doConfigureOptions(OptionsResolver $resolver): void {
        $resolver->setDefault('submitButtonLabel', 'Send Email');
    }

}
