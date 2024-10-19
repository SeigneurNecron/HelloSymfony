<?php

namespace App\Repository;

use App\Entity\Character;
use App\Entity\Element;
use App\Entity\Region;
use App\Entity\WeaponCategory;
use App\Repository\Base\AbstractNamedEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractNamedEntityRepository<Character>
 */
class CharacterRepository extends AbstractNamedEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Character::class);
    }

    /**
     * @return Character[] Returns an array of Character objects
     */
    public function findByFields(Element $element, WeaponCategory $weaponCategory, Region $region): array {
        $builder = $this->createQueryBuilder('c');

        if(!$element === null) {
            $builder->andWhere('c.element = :element')
                ->setParameter('element', $element);
        }

        if(!$weaponCategory === null) {
            $builder->andWhere('c.weaponCategory = :weaponCategory')
                ->setParameter('weaponCategory', $weaponCategory);
        }

        if(!$region === null) {
            $builder->andWhere('c.region = :region')
                ->setParameter('region', $region);
        }

        return $builder->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
