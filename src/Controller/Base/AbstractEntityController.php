<?php

declare(strict_types = 1);

namespace App\Controller\Base;

use App\Entity\Base\AbstractNameableEntity;
use App\Form\Base\AbstractEntityType;
use App\Form\Base\EntityDeletionType;
use App\Repository\Base\AbstractNameableEntityRepository;
use App\Utils\StringUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @template E of AbstractNameableEntity
 * @template F of AbstractEntityType<E>
 * @template R of AbstractNameableEntityRepository<E>
 */
abstract class AbstractEntityController extends AbstractController {

    protected readonly string $entityName;

    /**
     * @param class-string<E> $entityClass
     * @param class-string<F> $formClass
     * @param R $repository
     */
    protected function __construct(protected readonly string                           $entityClass,
                                   protected readonly string                           $formClass,
                                   protected readonly AbstractNameableEntityRepository $repository) {
        $this->entityName = StringUtils::getSimpleName($entityClass);
    }

    /**
     * @return E
     */
    protected function newEntity() {
        return new $this->entityClass();
    }

    /**
     * @param string $slug
     * @return E|null
     */
    protected function find(string $slug): ?AbstractNameableEntity {
        return $this->repository->findOneBySlug($slug);
    }

    /**
     * @param string $slug
     * @param callable<E> $treatment
     * @return Response
     */
    protected function findAndUseEntity(string $slug, callable $treatment): Response {
        $entity = $this->find($slug);

        if(!$entity) {
            $this->addFlash('error', "Could not find $this->entityName \"$slug\", return to list!");
            return $this->redirectToRoute($this->entityName . '_List');
        }

        return $treatment($entity);
    }

    #[Route(path: '', name: 'List')]
    public function list(): Response {
        $entities = $this->repository->findBy([], ['name' => 'ASC']);
        return $this->render('Prefab/List.html.twig', ['type' => $this->entityName, 'entities' => $entities]);
    }

    #[Route(path: '/{slug}', name: 'Details', requirements: ['slug' => '[a-zA-Z0-9]+'])]
    public function details(string $slug): Response {
        return $this->findAndUseEntity($slug, function(AbstractNameableEntity $entity) {
            return $this->render($this->entityName . '/Details.html.twig', ['type' => $this->entityName, 'entity' => $entity]);
        });
    }

    #[Route(path: '/{slug}/Edit', name: 'Edit', requirements: ['slug' => '[a-zA-Z0-9]+'])]
    public function edit(string $slug, Request $request, EntityManagerInterface $entityManager): Response {
        return $this->findAndUseEntity($slug, function(AbstractNameableEntity $entity) use ($request, $entityManager) {
            $form = $this->createForm($this->formClass, $entity, ['submitButtonLabel' => "Update"]);
            $form->handleRequest($request);

            if($form->isSubmitted()) {
                if($form->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', "$this->entityName \"{$entity->getName()}\" updated!");
                    return $this->redirectToRoute($this->entityName . '_Details', ['slug' => $entity->getSlug()]);
                }
                else {
                    $this->addFlash('error', "$this->entityName update failed!");
                }
            }

            return $this->render('Prefab/Edit.html.twig', ['type' => $this->entityName, 'entity' => $entity, 'form' => $form]);
        });
    }

    #[Route(path: '/{slug}/Delete', name: 'Delete', requirements: ['slug' => '[a-zA-Z0-9]+'])]
    public function delete(string $slug, Request $request, EntityManagerInterface $entityManager): Response {
        return $this->findAndUseEntity($slug, function(AbstractNameableEntity $entity) use ($request, $entityManager) {
            $form = $this->createForm(EntityDeletionType::class);
            $form->handleRequest($request);

            if($form->isSubmitted()) {
                if($form->isValid()) {
//                    $entityManager->remove($entity);
                    $entityManager->flush();
                    $this->addFlash('success', "$this->entityName \"{$entity->getName()}\" deleted!");
                    return $this->redirectToRoute($this->entityName . '_List');
                }
                else {
                    $this->addFlash('error', "$this->entityName deletion failed!");
                }
            }

            return $this->render('Prefab/Delete.html.twig', ['type' => $this->entityName, 'entity' => $entity, 'form' => $form]);
        });
    }

    // TODO check user is authorized to access edit/create/delete routes. Also don't display buttons that lead there.

}
