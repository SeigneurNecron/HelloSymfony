<?php

namespace App\Form\Entity;

use App\Entity\Final\Region;
use App\Form\Base\AbstractEntityType;
use App\Form\Trait\WithName;

/**
 * @template-extends AbstractEntityType<Region>
 */
class RegionType extends AbstractEntityType {

    use WithName;

    public function __construct() {
        parent::__construct(Region::class);
    }

}
