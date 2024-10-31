<?php

declare(strict_types = 1);

namespace App\Controller\Entity;

use App\Controller\Base\AbstractCreatableNameableEntityController;
use App\Form\Entity\RegionType;
use App\Service\Entity\Final\RegionManager;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @template-extends AbstractCreatableNameableEntityController<Region>
 */
#[Route('/Region', name: 'Region_')]
class RegionController extends AbstractCreatableNameableEntityController {

    public function __construct(RegionManager $manager) {
        parent::__construct($manager, RegionType::class);
    }

}
