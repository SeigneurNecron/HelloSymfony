<?php

namespace App\DataFixture;

use App\Entity\Base\AbstractEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template E of AbstractEntity
 */
abstract class AbstractFixtures extends Fixture {

    /**
     * @param ValidatorInterface $validator
     * @param class-string<E>    $entityClass
     */
    public function __construct(
        protected readonly ValidatorInterface $validator,
        protected readonly string             $entityClass,
    ) {}

    /**
     * @param ObjectManager $manager
     *
     * @return void
     * @throws Exception
     */
    public function load(ObjectManager $manager): void {
        $entityInfos = $this->getEntityInfos();

        foreach($entityInfos as $entityInfo) {
            $entity = $this->newEntity();
            $this->hydrateEntity($entity, $entityInfo);
            $entity->preValidate();
            $violations = $this->validator->validate($entity);

            if($violations->count()) {
                throw new ValidationFailedException($entity, $violations);
            }

            $manager->persist($entity);
            $this->addReference($this->entityClass . ' ' . $entity->__toString(), $entity);
        }

        $manager->flush();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected abstract function getEntityInfos(): array;

    /**
     * @return E
     */
    protected function newEntity() {
        return new $this->entityClass();
    }

    /**
     * @param E                    $entity
     * @param array<string, mixed> $entityInfo
     *
     * @return void
     * @throws Exception
     */
    protected abstract function hydrateEntity(AbstractEntity $entity, array $entityInfo): void;

    /**
     * @param E $entity
     *
     * @return void
     */
    protected function addEntityReference(AbstractEntity $entity): void {
        $this->addReference($this->entityClass . ' ' . $entity->__toString(), $entity);
    }

    /**
     * @template T
     * @param class-string<T> $entityClass
     * @param string          $key
     *
     * @return T|null
     */
    protected function getEntityReference(string $entityClass, string $key): ?object {
        return $this->getReference($entityClass . ' ' . $key);
    }

}
