<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Controller\Base\AbstractCreatableEntityController;
use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\RegionRepository;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/Region', name: 'Region_')]
class RegionController extends AbstractCreatableEntityController {

    public function __construct(RegionRepository $repository) {
        parent::__construct(Region::class, RegionType::class, $repository);
    }

    protected function newEntity(): Region {
        return new Region();
    }

}
