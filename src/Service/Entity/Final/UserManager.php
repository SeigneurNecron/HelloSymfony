<?php

namespace App\Service\Entity\Final;

use App\Entity\Final\User;
use App\Repository\Final\UserRepository;
use App\Service\Entity\Base\AbstractEntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template-extends AbstractEntityManager<User, UserRepository>
 */
readonly class UserManager extends AbstractEntityManager {

    public function __construct(
        UserRepository         $repository,
        EntityManagerInterface $entityManager,
        ValidatorInterface     $validator,
    ) {
        parent::__construct(
            User::class,
            $repository,
            $entityManager,
            $validator,
        );
    }

    public function findOneByUsernameOrEmail(string $username, string $email): ?User {
        return $this->repository->findOneByUsernameOrEmail($username, $email);
    }

}
