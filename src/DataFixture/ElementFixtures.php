<?php

namespace App\DataFixture;

use App\Entity\Base\AbstractEntity;
use App\Entity\Final\Element;
use App\Service\Entity\Final\ElementManager;
use Exception;

/**
 * @template-extends AbstractFixtures<Element>
 */
class ElementFixtures extends AbstractFixtures {

    public function __construct(ElementManager $entityManager) {
        parent::__construct($entityManager);
    }

    protected function getEntityInfos(): array {
        return [
            [
                'name'  => 'None',
                'color' => 'white',
            ],
            [
                'name'  => 'Electro',
                'color' => 'purple',
            ],
            [
                'name'  => 'Pyro',
                'color' => 'red',
            ],
            [
                'name'  => 'Hydro',
                'color' => 'blue',
            ],
            [
                'name'  => 'Cryo',
                'color' => 'light-blue',
            ],
            [
                'name'  => 'Geo',
                'color' => 'brown',
            ],
            [
                'name'  => 'Anemo',
                'color' => 'turquoise',
            ],
            [
                'name'  => 'Dendro',
                'color' => 'green',
            ],
        ];
    }

    /**
     * @param Element              $entity
     * @param array<string, mixed> $entityInfo
     *
     * @return void
     * @throws Exception
     */
    protected function hydrateEntity(AbstractEntity $entity, array $entityInfo): void {
        $entity
            ->setName($entityInfo['name'])
            ->setColor($entityInfo['color']);
    }

}
