<?php

namespace App\Utils;

use ReflectionObject;

class Reflect {

    /**
     * Returns an array of matching methods names as keys and Attribute instances as values.
     * @param object $object an instance of an object you want to find methods on.
     * @param string $attributeClass the FQN of an Attribute you want methods to have.
     * @return array<string, object>
     */
    public static function getMethodsAndAttribute(object $object, string $attributeClass): array {
        $reflection = new ReflectionObject($object);
        $matchingMethods = [];

        foreach($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes($attributeClass);

            if(count($attributes) > 0) {
                $matchingMethods += [$method->getName() => $attributes[0]->newInstance()];
            }
        }

        return $matchingMethods;
    }

    /**
     * Returns an array of matching methods names.
     * @param object $object an instance of an object you want to find methods on.
     * @param string $attributeClass the FQN of an Attribute class you want methods to have.
     * @return array<int, string>
     */
    public static function getMethodsWithAttribute(object $object, string $attributeClass): array {
        $reflection = new ReflectionObject($object);
        $matchingMethods = [];

        foreach($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes($attributeClass);

            if(count($attributes) > 0) {
                $matchingMethods[] = $method->getName();
            }
        }

        return $matchingMethods;
    }

}