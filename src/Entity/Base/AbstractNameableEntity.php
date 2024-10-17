<?php

namespace App\Entity\Base;

abstract class AbstractNameableEntity extends AbstractEntity {

    public abstract function getName(): ?string;

    public abstract function getSlug(): ?string;

}