<?php

namespace App\DataFixture;

use App\Entity\Base\AbstractEntity;
use App\Service\Entity\Base\AbstractEntityManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

/**
 * @template E of AbstractEntity
 */
abstract class AbstractFixtures extends Fixture {

    private readonly string $entityClass;

    /**
     * @param AbstractEntityManager<E> $entityManager
     */
    public function __construct(
        protected readonly AbstractEntityManager $entityManager,
    ) {
        $this->entityClass = $this->entityManager->entityClass;
    }

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
            $this->entityManager->create($entity);
            $this->addReference($this->entityClass . ' ' . $entity->__toString(), $entity);
        }
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
