<?php

namespace App\Entity\Base;

use App\Util\Reflect;
use Doctrine\ORM\Mapping as ORM;
use ReflectionAttribute;
use Stringable;

abstract class AbstractEntity implements Stringable {

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

}