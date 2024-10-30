<?php

namespace App\DataFixture;

use App\Entity\Base\AbstractEntity;
use App\Entity\Final\Region;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template-extends AbstractFixtures<Region>
 */
class RegionFixtures extends AbstractFixtures {

    public function __construct(ValidatorInterface $validator) {
        parent::__construct($validator, Region::class);
    }

    protected function getEntityInfos(): array {
        return [
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
        ];
    }

    /**
     * @param Region $entity
     * @param array<string, mixed> $entityInfo
     * @return void
     * @throws Exception
     */
    protected function hydrateEntity(AbstractEntity $entity, array $entityInfo): void {
        $entity
            ->setName($entityInfo['name']);
    }

}
