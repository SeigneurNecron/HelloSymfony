<?php

namespace App\Repository\Final;

use App\Entity\Final\Character;
use App\Entity\Final\Element;
use App\Entity\Final\Region;
use App\Entity\Final\WeaponCategory;
use App\Repository\Base\AbstractNamedEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends AbstractNamedEntityRepository<Character>
 */
class CharacterRepository extends AbstractNamedEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Character::class);
    }

    /**
     * @return Character[] Returns an array of Character objects
     */
    public function findByFields(Element $element, WeaponCategory $weaponCategory, Region $region): array {
        $builder = $this->createQueryBuilder('character');

        if(!$element === null) {
            $builder->andWhere('character.element = :element')
                    ->setParameter('element', $element);
        }

        if(!$weaponCategory === null) {
            $builder->andWhere('character.weaponCategory = :weaponCategory')
                    ->setParameter('weaponCategory', $weaponCategory);
        }

        if(!$region === null) {
            $builder->andWhere('character.region = :region')
                    ->setParameter('region', $region);
        }

        return $builder->orderBy('character.name', 'ASC')
                       ->getQuery()
                       ->getResult();
    }

}
