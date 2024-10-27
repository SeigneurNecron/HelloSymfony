<?php

declare(strict_types = 1);

namespace App\Controller\Base;

use App\Constants\EntityPermission as EP;
use App\Constants\MessageType as MT;
use App\Entity\Base\AbstractNameableEntity;
use App\Form\Base\AbstractEntityType;
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
     * @param bool $withDetails
     * @return E|null
     */
    protected function find(string $slug, bool $withDetails): ?AbstractNameableEntity {
        return $this->repository->findOneBySlug($slug, $withDetails);
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
     * @param bool $withDetails
     * @param callable(E $entity):Response $treatment
     * @return Response
     */
    protected function checkPermissionFindEntityAndDo(string $permission, string $slug, bool $withDetails, callable $treatment): Response {
        $this->denyAccessUnlessGranted($permission, $this->entityClass);

        $entity = $this->find($slug, $withDetails);

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
        return $this->checkPermissionFindEntityAndDo(EP::READ, $slug, true, function(AbstractNameableEntity $entity) {
            return $this->render('Entity/Details/' . $this->entityName . '.html.twig', ['type' => $this->entityName, 'entity' => $entity]);
        });
    }

    #[Route(path: '/{slug}/Edit', name: 'Edit', requirements: ['slug' => '[a-zA-Z0-9]+'])]
    public function edit(string $slug, Request $request, EntityManagerInterface $entityManager): Response {
        return $this->checkPermissionFindEntityAndDo(EP::UPDATE, $slug, false, function(AbstractNameableEntity $entity) use ($request, $entityManager) {
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
