<?php

namespace App\Form\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class BuildFormMethod {

    public function __construct(public readonly bool $atTheEnd = false) {
    }

}
