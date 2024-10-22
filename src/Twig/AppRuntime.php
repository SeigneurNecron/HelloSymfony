<?php

namespace App\Twig;

use App\Entity\Base\AbstractNameableEntity;
use App\Utils\StringUtils;
use BackedEnum;
use DateTimeInterface;
use Stringable;
use Twig\Extension\RuntimeExtensionInterface;
use UnitEnum;

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

    public function mixedToString(mixed $thing): string {
        $type = gettype($thing);

        return match ($type) {
            'string' => $thing,
            'object' => $this->objectToString($thing),
            'boolean' => $thing ? "Yes" : "No",
            'integer', 'double' => "$thing",
            default => "[$type]"
        };
    }

    public function objectToString(object $object): string {
        if($object instanceof Stringable) {
            return $object->__toString();
        }
        elseif($object instanceof BackedEnum) {
            return $object->value;
        }
        elseif($object instanceof UnitEnum) {
            return $object->name;
        }
        elseif($object instanceof DateTimeInterface) {
            $date = $object->format('Y-m-d');
            $time = $object->format('H:i:s');

            if($time == '00:00:00') {
                return $date;
            }

            return "$date $time";
        }

        $class = StringUtils::getClassSimpleName($object);
        return "[$class]";
    }

    public function isNameableEntity(mixed $thing): bool {
        return $thing instanceof AbstractNameableEntity;
    }

}