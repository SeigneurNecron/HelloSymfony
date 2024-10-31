<?php

namespace App\Util;

use App\Entity\Base\AbstractEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToMany;

readonly class EntityDeletionInfo {

    public bool  $canDelete;
    public array $emptyFields;
    public array $lockedFields;
    public array $cascadeFields;

    public function __construct(AbstractEntity $entity) {
        $canDelete     = true;
        $emptyFields   = [];
        $lockedFields  = [];
        $cascadeFields = [];

        /** @var OneToMany $attribute */
        foreach($entity->getParentFields() as $parentField => $attribute) {
            $getter = 'get' . ucfirst($parentField);

            /** @var Collection<int, AbstractEntity> $parent */
            $parent = $entity->$getter();

            $count = $parent->count();

            if($count > 0) {
                if($attribute->orphanRemoval) {
                    $cascadeFields[] = $parentField;
                }
                else {
                    $lockedFields[] = $parentField;
                    $canDelete      = false;
                }
            }
            else {
                $emptyFields[] = $parentField;
            }
        }

        $this->canDelete     = $canDelete;
        $this->emptyFields   = $emptyFields;
        $this->lockedFields  = $lockedFields;
        $this->cascadeFields = $cascadeFields;
    }

}