<?php

namespace App\Repository\Final;

use App\Entity\Final\User;
use App\Repository\Base\AbstractEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @template-extends AbstractEntityRepository<User>
 */
class UserRepository extends AbstractEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void {
        if(!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findOneByUsernameOrEmail(string $username, string $email): ?User {
        return $this->createQueryBuilder('user')
                    ->where('user.username = :username')
                    ->orWhere('user.email = :email')
                    ->setParameter('username', $username)
                    ->setParameter('email', $email)
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    public function loadUserByIdentifier(string $identifier): ?UserInterface {
        return $this->findOneByIdentifier($identifier);
    }

    public function findOneByIdentifier(string $identifier): ?User {
        return $this->createQueryBuilder('user')
                    ->where('user.username = :userNameOrEmail')
                    ->orWhere('user.email = :userNameOrEmail')
                    ->setParameter('userNameOrEmail', $identifier)
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

}
