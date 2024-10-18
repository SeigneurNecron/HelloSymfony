<?php

namespace App\Utils;

class StringUtils {

    /**
     * Returns a class simple name from it's Fully Qualified Name.
     * @param class-string $className
     * @return string
     */
    public static function getSimpleName(string $className): string {
        $splitClassName = explode('\\', $className);
        return $splitClassName[count($splitClassName) - 1];
    }

    /**
     * Returns the class Fully Qualified Name of an object.
     * @param object $object
     * @return string
     */
    public static function getClassName(object $object): string {
        return get_class($object);
    }

    /**
     * Returns the class simple name of an object.
     * @param object $object
     * @return string
     */
    public static function getClassSimpleName(object $object): string {
        return self::getSimpleName(self::getClassName($object));
    }

}