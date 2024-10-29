<?php

namespace App\DataFixtures;

use App\Constants\UserRole;
use App\Entity\Base\AbstractEntity;
use App\Entity\Final\User;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template-extends AbstractFixtures<User>
 */
class UserFixtures extends AbstractFixtures {

    public function __construct(ValidatorInterface $validator, private readonly UserPasswordHasherInterface $hasher) {
        parent::__construct($validator, User::class);
    }

    protected function getEntityInfos(): array {
        return [
            [
                'username' => 'JudgeDead',
                'email' => 'judge.dead@test.com',
                'password' => '4444',
                'roles' => [UserRole::ROLE_ADMIN],
                'verified' => true,
            ],
            [
                'username' => 'JeanMich',
                'email' => 'jean.mich@test.com',
                'password' => 'aaaaaa',
                'roles' => [],
                'verified' => true,
            ],
            [
                'username' => 'JackSparou',
                'email' => 'jack.sparou@test.com',
                'password' => 'aaaaaa',
                'roles' => [],
                'verified' => false,
            ],
        ];
    }

    /**
     * @param User $entity
     * @param array<string, mixed> $entityInfo
     * @return void
     * @throws Exception
     */
    protected function hydrateEntity(AbstractEntity $entity, array $entityInfo): void {
        $entity
            ->setUsername($entityInfo['username'])
            ->setEmail($entityInfo['email'])
            ->setPassword($this->hasher->hashPassword($entity, $entityInfo['password']))
            ->setRoles($entityInfo['roles'])
            ->setVerified($entityInfo['verified']);
    }

}
