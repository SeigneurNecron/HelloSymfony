<?php

namespace App\Exception;

use Exception;
use Throwable;

class SecretValidationFailedException extends Exception {

    public function __construct(?Throwable $previous = null) {
        parent::__construct("Something went wrong.", previous: $previous);
    }

}