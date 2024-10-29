<?php

namespace App\DataFixtures;

use App\Entity\Base\AbstractEntity;
use App\Entity\Final\Element;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template-extends AbstractFixtures<Element>
 */
class ElementFixtures extends AbstractFixtures {

    public function __construct(ValidatorInterface $validator) {
        parent::__construct($validator, Element::class);
    }

    protected function getEntityInfos(): array {
        return [
            [
                'name' => 'Electro',
                'color' => 'purple',
            ],
            [
                'name' => 'Pyro',
                'color' => 'red',
            ],
            [
                'name' => 'Hydro',
                'color' => 'blue',
            ],
            [
                'name' => 'Cryo',
                'color' => 'light-blue',
            ],
            [
                'name' => 'Geo',
                'color' => 'brown',
            ],
            [
                'name' => 'Anemo',
                'color' => 'turquoise',
            ],
            [
                'name' => 'Dendro',
                'color' => 'green',
            ],
        ];
    }

    /**
     * @param Element $entity
     * @param array<string, mixed> $entityInfo
     * @return void
     * @throws Exception
     */
    protected function hydrateEntity(AbstractEntity $entity, array $entityInfo): void {
        $entity
            ->setName($entityInfo['name'])
            ->setColor($entityInfo['color']);
    }

}
