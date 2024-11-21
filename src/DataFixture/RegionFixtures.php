<?php

namespace App\DataFixture;

use App\Entity\Base\AbstractEntity;
use App\Entity\Final\Region;
use App\Service\Entity\Final\RegionManager;
use Exception;

/**
 * @template-extends AbstractFixtures<Region>
 */
class RegionFixtures extends AbstractFixtures {

    public function __construct(RegionManager $entityManager) {
        parent::__construct($entityManager);
    }

    protected function getEntityInfos(): array {
        return [
            [
                'name' => 'None',
            ],
            [
                'name' => 'Mondstadt',
            ],
            [
                'name' => 'Liyue',
            ],
            [
                'name' => 'Inazuma',
            ],
            [
                'name' => 'Sumeru',
            ],
            [
                'name' => 'Fontaine',
            ],
            [
                'name' => 'Natlan',
            ],
            [
                'name' => 'Snezhnaya',
            ],
        ];
    }

    /**
     * @param Region               $entity
     * @param array<string, mixed> $entityInfo
     *
     * @return void
     * @throws Exception
     */
    protected function hydrateEntity(AbstractEntity $entity, array $entityInfo): void {
        $entity
            ->setName($entityInfo['name']);
    }

}
