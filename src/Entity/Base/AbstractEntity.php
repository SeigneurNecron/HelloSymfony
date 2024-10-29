<?php

namespace App\Entity\Base;

use App\Utils\Reflect;
use Doctrine\ORM\Mapping as ORM;
use ReflectionAttribute;

abstract class AbstractEntity {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return array<string, ReflectionAttribute>
     */
    public function getChildFields(): array {
        return Reflect::getFieldsAndAttribute($this, ORM\ManyToOne::class);
    }

    /**
     * @return array<string, ReflectionAttribute>
     */
    public function getParentFields(): array {
        return Reflect::getFieldsAndAttribute($this, ORM\OneToMany::class);
    }

    public function preValidate(): void {}

}