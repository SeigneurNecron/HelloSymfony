<?php

namespace App\Service\Entity\Final;

use App\Entity\Final\WeaponCategory;
use App\Repository\Final\WeaponCategoryRepository;
use App\Service\Entity\Base\AbstractNamedEntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template-extends AbstractNamedEntityManager<WeaponCategory, WeaponCategoryRepository>
 */
readonly class WeaponCategoryManager extends AbstractNamedEntityManager {

    public function __construct(
        WeaponCategoryRepository $repository,
        EntityManagerInterface   $entityManager,
        ValidatorInterface       $validator,
    ) {
        parent::__construct(
            WeaponCategory::class,
            $repository,
            $entityManager,
            $validator,
        );
    }

}
