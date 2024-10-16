<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractEntity {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    public function getId(): ?int {
        return $this->id;
    }

}