<?php

declare(strict_types = 1);

namespace App\Controller\Entity;

use App\Controller\Base\AbstractCreatableNameableEntityController;
use App\Entity\Final\ArtifactSet;
use App\Form\Entity\ArtifactSetType;
use App\Service\Entity\Final\ArtifactSetManager;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @template-extends AbstractCreatableNameableEntityController<ArtifactSet>
 */
#[Route('/ArtifactSet', name: 'ArtifactSet_')]
class ArtifactSetController extends AbstractCreatableNameableEntityController {

    public function __construct(ArtifactSetManager $manager) {
        parent::__construct($manager, ArtifactSetType::class);
    }

}
