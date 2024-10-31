<?php

namespace App\Service\Entity\Final;

use App\Entity\Final\Element;
use App\Repository\Final\ElementRepository;
use App\Service\Entity\Base\AbstractNamedEntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template-extends AbstractNamedEntityManager<Element>
 */
readonly class ElementManager extends AbstractNamedEntityManager {

    public function __construct(
        ElementRepository      $repository,
        EntityManagerInterface $entityManager,
        ValidatorInterface     $validator,
    ) {
        parent::__construct(
            Element::class,
            $repository,
            $entityManager,
            $validator,
        );
    }

}
