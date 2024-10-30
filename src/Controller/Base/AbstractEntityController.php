<?php

declare(strict_types = 1);

namespace App\Controller\Base;

use App\Constant\EntityPermission as EP;
use App\Constant\MessageType as MT;
use App\Entity\Base\AbstractNameableEntity;
use App\Enum\QueryMode;
use App\Form\Base\AbstractEntityType;
use App\Repository\Base\AbstractNameableEntityRepository;
use App\Util\StringUtils;
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
    protected function __construct(
        protected readonly string                           $entityClass,
        protected readonly string                           $formClass,
        protected readonly AbstractNameableEntityRepository $repository
    ) {
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
     * @param QueryMode $queryMode
     * @return E|null
     */
    protected function find(string $slug, QueryMode $queryMode): ?AbstractNameableEntity {
        return $this->repository->findOneBySlug($slug, $queryMode);
    }

    /**
     * @param string $permission
     * @param callable():Response $treatment
     * @return Response
     */
    protected function checkPermissionAndDo(string $permission, callable $treatment): Response {
        $this->denyAccessUnlessGranted($permission, $this->entityClass);
        return $treatment();
    }

    /**
     * @param string $permission
     * @param string $slug
     * @param QueryMode $queryMode
     * @param callable(E $entity):Response $treatment
     * @return Response
     */
    protected function checkPermissionFindEntityAndDo(string $permission, string $slug, QueryMode $queryMode, callable $treatment): Response {
        $this->denyAccessUnlessGranted($permission, $this->entityClass);

        $entity = $this->find($slug, $queryMode);

        if(!$entity) {
            $this->addFlash(MT::ERROR, "Could not find $this->entityName \"$slug\", return to list!");
            return $this->redirectToRoute($this->entityName . '_List');
        }

        return $treatment($entity);
    }

    #[Route(path: '', name: 'List')]
    public function list(): Response {
        return $this->checkPermissionAndDo(EP::LIST, function() {
            $entities = $this->repository->findBy([], ['name' => 'ASC']);
            return $this->render('Entity/Prefab/List.html.twig', ['type' => $this->entityName, 'entities' => $entities]);
        });
    }

    #[Route(path: '/{slug}', name: 'Details', requirements: ['slug' => '[a-zA-Z0-9]+'])]
    public function details(string $slug): Response {
        return $this->checkPermissionFindEntityAndDo(EP::READ, $slug, QueryMode::WithChildren, function(AbstractNameableEntity $entity) {
            return $this->render('Entity/Details/' . $this->entityName . '.html.twig', ['type' => $this->entityName, 'entity' => $entity]);
        });
    }

    #[Route(path: '/{slug}/Edit', name: 'Edit', requirements: ['slug' => '[a-zA-Z0-9]+'])]
    public function edit(string $slug, Request $request, EntityManagerInterface $entityManager): Response {
        return $this->checkPermissionFindEntityAndDo(EP::UPDATE, $slug, QueryMode::Simple, function(AbstractNameableEntity $entity) use ($request, $entityManager) {
            $form = $this->createForm($this->formClass, $entity, ['submitButtonLabel' => "Update"]);
            $form->handleRequest($request);

            if($form->isSubmitted()) {
                if($form->isValid()) {
                    $entityManager->flush();
                    $this->addFlash(MT::SUCCESS, "$this->entityName \"{$entity->getName()}\" updated!");
                    return $this->redirectToRoute($this->entityName . '_Details', ['slug' => $entity->getSlug()]);
                }
                else {
                    $this->addFlash(MT::ERROR, "$this->entityName update failed!");
                }
            }

            return $this->render('Entity/Prefab/Edit.html.twig', ['type' => $this->entityName, 'entity' => $entity, 'form' => $form]);
        });
    }

}
