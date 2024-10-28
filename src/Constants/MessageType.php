<?php

namespace App\Constants;

class MessageType {

    const INFO = 'info';
    const SUCCESS = 'success';
    const WARNING = 'warning';
    const ERROR = 'danger';

    const VALUES = [self::SUCCESS, self::WARNING, self::ERROR];

}