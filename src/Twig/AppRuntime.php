<?php

namespace App\Twig;

use App\Entity\Base\AbstractNameableEntity;
use App\Entity\Base\AbstractNamedEntity;
use App\Entity\Final\Character;
use App\Entity\Final\Element;
use App\Entity\Final\Region;
use App\Entity\Final\User;
use App\Entity\Final\WeaponCategory;
use App\Util\Reflect;
use App\Util\StringUtils;
use BackedEnum;
use DateTimeInterface;
use Doctrine\ORM\Mapping\OneToMany;
use Stringable;
use Twig\Extension\RuntimeExtensionInterface;
use UnitEnum;

class AppRuntime implements RuntimeExtensionInterface {

    private readonly array $entityClasses;

    public function __construct() {
        $entityFQNs = [Character::class, Element::class, WeaponCategory::class, Region::class, User::class];
        $entityClasses = [];

        foreach($entityFQNs as $entityFQN) {
            $entityClasses[$this->getSimpleName($entityFQN)] = $entityFQN;
        }

        $this->entityClasses = $entityClasses;
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

    public function getFQN(string $classSimpleName): string {
        return $this->entityClasses[$classSimpleName];
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

    public function isNamedEntity(mixed $thing): bool {
        return $thing instanceof AbstractNamedEntity;
    }

    public function getParentEntityFields(object $entity): array {
        return Reflect::getFieldsWithAttribute($entity, OneToMany::class);
    }

}