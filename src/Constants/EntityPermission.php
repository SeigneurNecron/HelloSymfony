<?php

namespace App\Constants;

class EntityPermission {

    const LIST = 'LIST';
    const CREATE = 'CREATE';
    const READ = 'READ';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE';

    const VALUES = [self::LIST, self::CREATE, self::READ, self::UPDATE, self::DELETE];
    const CUD = [self::CREATE, self::UPDATE, self::DELETE];

}