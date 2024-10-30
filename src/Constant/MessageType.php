<?php

namespace App\Constant;

class MessageType {

    const INFO    = 'info';
    const SUCCESS = 'success';
    const WARNING = 'warning';
    const ERROR   = 'danger';

    const VALUES = [self::SUCCESS, self::WARNING, self::ERROR];

}