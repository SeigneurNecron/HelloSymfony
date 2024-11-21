<?php

namespace App\Service\Entity\Final;

use App\Entity\Final\ArtifactSet;
use App\Repository\Final\ArtifactSetRepository;
use App\Service\Entity\Base\AbstractNamedEntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template-extends AbstractNamedEntityManager<ArtifactSet, ArtifactSetRepository>
 */
readonly class ArtifactSetManager extends AbstractNamedEntityManager {

    public function __construct(
        ArtifactSetRepository  $repository,
        EntityManagerInterface $entityManager,
        ValidatorInterface     $validator,
    ) {
        parent::__construct(
            ArtifactSet::class,
            $repository,
            $entityManager,
            $validator,
        );
    }

}
