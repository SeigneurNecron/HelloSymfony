<?php

namespace App\DataFixture;

use App\Entity\Base\AbstractEntity;
use App\Entity\Final\Character;
use App\Entity\Final\Element;
use App\Entity\Final\Region;
use App\Entity\Final\WeaponCategory;
use App\Enum\Genre;
use App\Enum\Size;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template-extends AbstractFixtures<Character>
 */
class CharacterFixtures extends AbstractFixtures implements DependentFixtureInterface {

    public function __construct(ValidatorInterface $validator) {
        parent::__construct($validator, Character::class);
    }

    /**
     * @return class-string[]
     */
    public function getDependencies(): array {
        return [ElementFixtures::class, WeaponCategoryFixtures::class, RegionFixtures::class];
    }

    protected function getEntityInfos(): array {
        return [
            [
                'name' => 'Amber',
                'rare' => false,
                'element' => 'Pyro',
                'weaponCategory' => 'Bow',
                'region' => 'Mondstadt',
                'genre' => Genre::Female,
                'size' => Size::Medium,
                'releaseDate' => '2020-09-28',
                'version' => '1.0',
            ],
        ];
    }

    /**
     * @param Character $entity
     * @param array<string, mixed> $entityInfo
     * @return void
     * @throws Exception
     */
    protected function hydrateEntity(AbstractEntity $entity, array $entityInfo): void {
        $entity
            ->setName($entityInfo['name'])
            ->setRare($entityInfo['rare'])
            ->setElement($this->getEntityReference(Element::class, $entityInfo['element']))
            ->setWeaponCategory($this->getEntityReference(WeaponCategory::class, $entityInfo['weaponCategory']))
            ->setRegion($this->getEntityReference(Region::class, $entityInfo['region']))
            ->setGenre($entityInfo['genre'])
            ->setSize($entityInfo['size'])
            ->setReleaseDate(new DateTimeImmutable($entityInfo['releaseDate']))
            ->setVersion($entityInfo['version']);
    }

}
