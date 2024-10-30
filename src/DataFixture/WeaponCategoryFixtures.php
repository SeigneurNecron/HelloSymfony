<?php

namespace App\DataFixture;

use App\Entity\Base\AbstractEntity;
use App\Entity\Final\WeaponCategory;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template-extends AbstractFixtures<WeaponCategory>
 */
class WeaponCategoryFixtures extends AbstractFixtures {

    public function __construct(ValidatorInterface $validator) {
        parent::__construct($validator, WeaponCategory::class);
    }

    protected function getEntityInfos(): array {
        return [
            [
                'name' => 'Sword',
            ],
            [
                'name' => 'Claymore',
            ],
            [
                'name' => 'Polearm',
            ],
            [
                'name' => 'Bow',
            ],
            [
                'name' => 'Catalyst',
            ],
        ];
    }

    /**
     * @param WeaponCategory       $entity
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
