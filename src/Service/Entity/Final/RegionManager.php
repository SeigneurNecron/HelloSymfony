<?php

namespace App\Service\Entity\Final;

use App\Entity\Final\Region;
use App\Repository\Final\RegionRepository;
use App\Service\Entity\Base\AbstractNamedEntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template-extends AbstractNamedEntityManager<Region>
 */
readonly class RegionManager extends AbstractNamedEntityManager {

    public function __construct(
        RegionRepository       $repository,
        EntityManagerInterface $entityManager,
        ValidatorInterface     $validator,
    ) {
        parent::__construct(
            Region::class,
            $repository,
            $entityManager,
            $validator,
        );
    }

}
