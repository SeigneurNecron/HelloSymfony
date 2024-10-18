<?php

namespace App\Twig;

use App\Utils\StringUtils;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface {

    public function __construct() {
        // Can use this constructor to inject services
    }

    public function getSimpleName(string $className): string {
        return StringUtils::getSimpleName($className);
    }

    public function getClassName(object $object): string {
        return $object ? StringUtils::getClassName($object) : "null";
    }

    public function getClassSimpleName(object $object): string {
        return $object ? StringUtils::getClassSimpleName($object) : "null";
    }

}