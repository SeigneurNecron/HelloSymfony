<?php

namespace App\Service\Entity\Base;

use App\Constant\ValidationGroup;
use App\Entity\Base\AbstractEntity;
use App\Exception\SecretValidationFailedException;
use App\Repository\Base\AbstractEntityRepository;
use App\Util\StringUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template E of AbstractEntity
 * @template R of AbstractEntityRepository<E>
 */
abstract readonly class AbstractEntityManager {

    public string $entityClassName;

    /**
     * @param class-string<E>        $entityClass
     * @param R                      $repository
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface     $validator
     */
    public function __construct(
        public string                      $entityClass,
        protected AbstractEntityRepository $repository,
        protected EntityManagerInterface   $entityManager,
        protected ValidatorInterface       $validator,
    ) {
        $this->entityClassName = StringUtils::getSimpleName($entityClass);
    }

    /**
     * @return E
     */
    public function newEntity(): AbstractEntity {
        return new $this->entityClass();
    }

    /**
     * @return array<E>
     */
    public function findAll(): array {
        return $this->repository->findAll();
    }

    /**
     * @param E $entity
     *
     * @return void
     * @throws ValidationFailedException|SecretValidationFailedException
     */
    public function update(AbstractEntity $entity): void {
        $this->validate($entity);
        $this->entityManager->flush();
    }

    /**
     * @param E $entity
     *
     * @return void
     * @throws ValidationFailedException|SecretValidationFailedException
     */
    public function create(AbstractEntity $entity): void {
        $this->validate($entity);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param E $entity
     *
     * @return void
     */
    public function delete(AbstractEntity $entity): void {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * @param E $entity
     *
     * @return void
     */
    protected function preValidate(AbstractEntity $entity): void {}

    /**
     * @param E $entity
     *
     * @return void
     * @throws ValidationFailedException
     * @throws SecretValidationFailedException
     */
    private function validate(AbstractEntity $entity): void {
        $this->preValidate($entity);
        $violations = $this->validator->validate($entity, groups: ValidationGroup::NOT_SECRET);

        if($violations->count()) {
            throw new ValidationFailedException($entity, $violations);
        }

        $violations = $this->validator->validate($entity, groups: ValidationGroup::SECRET);

        if($violations->count()) {
            throw new SecretValidationFailedException(new ValidationFailedException($entity, $violations));
        }
    }

}
