<?php

namespace App\Entity;

abstract class AbstractNameableEntity extends AbstractEntity {

    public abstract function getName(): ?string;

}