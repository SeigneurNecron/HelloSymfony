<?php

declare(strict_types = 1);

namespace App\Controller\Entity;

use App\Controller\Base\AbstractCreatableEntityController;
use App\Entity\Final\Region;
use App\Form\Entity\RegionType;
use App\Repository\Final\RegionRepository;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/Region', name: 'Region_')]
class RegionController extends AbstractCreatableEntityController {

    public function __construct(RegionRepository $repository) {
        parent::__construct(Region::class, RegionType::class, $repository);
    }

}
