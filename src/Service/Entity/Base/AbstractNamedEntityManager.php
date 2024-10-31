<?php

namespace App\Service\Entity\Base;

use App\Entity\Base\AbstractEntity;
use App\Entity\Base\AbstractNamedEntity;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @template E of AbstractNamedEntity
 * @template-extends AbstractNameableEntityManager
 */
abstract readonly class AbstractNamedEntityManager extends AbstractNameableEntityManager {

    /**
     * @param E $entity
     *
     * @return void
     */
    protected function preValidate(AbstractEntity $entity): void {
        parent::preValidate($entity);
        
        if(!$entity->getSlug()) {
            $slugger = new AsciiSlugger();
            $entity->setSlug($slugger->slug($entity->getName(), ''));
        }
    }

}