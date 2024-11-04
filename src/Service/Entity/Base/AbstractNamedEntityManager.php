<?php

namespace App\Service\Entity\Base;

use App\Entity\Base\AbstractEntity;
use App\Entity\Base\AbstractNamedEntity;
use App\Repository\Base\AbstractNamedEntityRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @template E of AbstractNamedEntity
 * @template R of AbstractNamedEntityRepository<E>
 * @template-extends AbstractNameableEntityManager<E, R>
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