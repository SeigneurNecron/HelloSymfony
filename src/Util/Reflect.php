<?php

namespace App\Util;

use ReflectionAttribute;
use ReflectionObject;

class Reflect {

    private const METHODS = 'getMethods';
    private const FIELDS = 'getProperties';

    private static function getMembersWithAttribute(object $object, string $getMembersFunction, string $attributeClass): array {
        $reflection = new ReflectionObject($object);
        $matchingMembers = [];

        foreach($reflection->$getMembersFunction() as $member) {
            /** @var ReflectionAttribute[] $attributes */
            $attributes = $member->getAttributes($attributeClass);

            if(count($attributes) > 0) {
                $matchingMembers[] = $member->getName();
            }
        }

        return $matchingMembers;
    }

    /**
     * Returns an array of matching methods names.
     * @param object $object an instance of an object you want to find methods on.
     * @param string $attributeClass the FQN of an Attribute class you want methods to have.
     * @return array<int, string>
     */
    public static function getMethodsWithAttribute(object $object, string $attributeClass): array {
        return self::getMembersWithAttribute($object, self::METHODS, $attributeClass);
    }

    /**
     * Returns an array of matching fields names.
     * @param object $object an instance of an object you want to find fields on.
     * @param string $attributeClass the FQN of an Attribute class you want fields to have.
     * @return array<int, string>
     */
    public static function getFieldsWithAttribute(object $object, string $attributeClass): array {
        return self::getMembersWithAttribute($object, self::FIELDS, $attributeClass);
    }

    private static function getMembersAndAttribute(object $object, string $getMembersFunction, string $attributeClass): array {
        $reflection = new ReflectionObject($object);
        $matchingMembers = [];

        foreach($reflection->$getMembersFunction() as $members) {
            /** @var ReflectionAttribute[] $attributes */
            $attributes = $members->getAttributes($attributeClass);

            if(count($attributes) > 0) {
                $matchingMembers += [$members->getName() => $attributes[0]->newInstance()];
            }
        }

        return $matchingMembers;
    }

    /**
     * Returns an array of matching methods names as keys and Attribute instances as values.
     * @param object $object an instance of an object you want to find methods on.
     * @param string $attributeClass the FQN of an Attribute you want methods to have.
     * @return array<string, ReflectionAttribute>
     */
    public static function getMethodsAndAttribute(object $object, string $attributeClass): array {
        return self::getMembersAndAttribute($object, self::METHODS, $attributeClass);
    }

    /**
     * Returns an array of matching fields names as keys and Attribute instances as values.
     * @param object $object an instance of an object you want to find fields on.
     * @param string $attributeClass the FQN of an Attribute you want fields to have.
     * @return array<string, ReflectionAttribute>
     */
    public static function getFieldsAndAttribute(object $object, string $attributeClass): array {
        return self::getMembersAndAttribute($object, self::FIELDS, $attributeClass);
    }

}
