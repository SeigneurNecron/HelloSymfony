<?php

declare(strict_types = 1);

namespace App\Controller\Base;

use App\Entity\Base\AbstractNamedEntity;
use App\Form\Base\AbstractEntityType;
use App\Repository\Base\AbstractEntityRepository;
use App\Utils\StringUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @template E of AbstractNamedEntity
 * @template F of AbstractEntityType<E>
 * @template R of AbstractEntityRepository<E>
 */
abstract class AbstractEntityController extends AbstractController {

    protected readonly string $entityName;

    /**
     * @param class-string<E> $entityClass
     * @param class-string<F> $formClass
     * @param R $repository
     */
    protected function __construct(protected readonly string                   $entityClass,
                                   protected readonly string                   $formClass,
                                   protected readonly AbstractEntityRepository $repository) {
        $this->entityName = StringUtils::getSimpleName($entityClass);
    }

    /**
     * @return E
     */
    protected function newEntity() {
        return new $this->entityClass();
    }

    protected function find(int $id): object {
        return $this->repository->find($id);
    }

    #[Route(path: '', name: 'List')]
    public function list(): Response {
        $entities = $this->repository->findBy([], ['name' => 'ASC']);
        return $this->render('Prefab/List.html.twig', ['type' => $this->entityName, 'entities' => $entities]);
    }

    #[Route(path: '/Details/{id}', name: 'Details')]
    public function details(int $id): Response {
        // TODO find by name instead of id
        $entity = $this->find($id);
        return $this->render($this->entityName . '/Details.html.twig', ['type' => $this->entityName, 'entity' => $entity]);
    }

    #[Route(path: '/Edit/{id}', name: 'Edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response {
        // TODO maybe find by name instead of id, but that might cause issues if the entity is renamed
        $entity = $this->find($id);
        $form = $this->createForm($this->formClass, $entity, ['submitButtonLabel' => "Update"]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', $this->entityName . " updated!");
            return $this->redirectToRoute($this->entityName . '_Details', ['id' => $id]);
        }

        return $this->render('Prefab/Edit.html.twig', ['type' => $this->entityName, 'entity' => $entity, 'form' => $form]);
    }

}
