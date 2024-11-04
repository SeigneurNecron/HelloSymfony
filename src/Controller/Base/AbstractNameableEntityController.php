<?php

declare(strict_types = 1);

namespace App\Controller\Base;

use App\Constant\EntityPermission as EP;
use App\Constant\MessageType as MT;
use App\Entity\Base\AbstractNameableEntity;
use App\Enum\QueryMode;
use App\Exception\SecretValidationFailedException;
use App\Form\Base\AbstractEntityType;
use App\Service\Entity\Base\AbstractNameableEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Exception\ValidationFailedException;

/**
 * @template E of AbstractNameableEntity
 * @template F of AbstractEntityType<E>
 */
abstract class AbstractNameableEntityController extends AbstractController {

    protected readonly string $entityClass;
    protected readonly string $entityClassName;

    /**
     * @param AbstractNameableEntityManager<E> $manager
     * @param class-string<F>                  $formClass
     */
    protected function __construct(
        protected readonly AbstractNameableEntityManager $manager,
        protected readonly string                        $formClass,
    ) {
        $this->entityClass     = $this->manager->entityClass;
        $this->entityClassName = $this->manager->entityClassName;
    }

    #[Route(path: '', name: 'List')]
    public function list(): Response {
        return $this->checkPermissionAndDo(
            EP::LIST,
            function() {
                $entities = $this->manager->findAll();

                return $this->render(
                    'Entity/Prefab/List.html.twig',
                    [
                        'type'     => $this->entityClassName,
                        'entities' => $entities,
                    ],
                );
            },
        );
    }

    #[Route(path: '/{slug}', name: 'Details', requirements: ['slug' => '[a-zA-Z0-9]+'])]
    public function details(string $slug): Response {
        return $this->checkPermissionFindEntityAndDo(
            EP::READ,
            $slug,
            QueryMode::WithChildren,
            function(AbstractNameableEntity $entity) {
                return $this->render(
                    'Entity/Details/' . $this->entityClassName . '.html.twig',
                    [
                        'type'   => $this->entityClassName,
                        'entity' => $entity,
                    ],
                );
            },
        );
    }

    #[Route(path: '/{slug}/Edit', name: 'Edit', requirements: ['slug' => '[a-zA-Z0-9]+'])]
    public function edit(string $slug, Request $request): Response {
        return $this->checkPermissionFindEntityAndDo(
            EP::UPDATE,
            $slug,
            QueryMode::Simple,
            function(AbstractNameableEntity $entity) use ($request) {
                $form = $this->createForm($this->formClass, $entity, ['submitButtonLabel' => "Update"]);
                $form->handleRequest($request);

                if($form->isSubmitted()) {
                    if($form->isValid()) {
                        try {
                            $this->manager->update($entity);
                            $this->addFlash(MT::SUCCESS, "$this->entityClassName \"{$entity->getName()}\" updated!");

                            return $this->redirectToRoute(
                                $this->entityClassName . '_Details',
                                ['slug' => $entity->getSlug()],
                            );
                        }
                        catch(ValidationFailedException $e) {
                            $this->addFlash(MT::ERROR, $e->getMessage());
                        }
                        catch(SecretValidationFailedException $e) {
                            $this->addFlash(MT::ERROR, "Something went wrong. $this->entityClassName update failed!");
                        }
                    }
                    else {
                        $this->addFlash(MT::ERROR, "$this->entityClassName update failed!");
                    }
                }

                return $this->render(
                    'Entity/Prefab/Edit.html.twig',
                    [
                        'type'   => $this->entityClassName,
                        'entity' => $entity,
                        'form'   => $form,
                    ],
                );
            },
        );
    }

    /**
     * @param string              $permission
     * @param callable():Response $treatment
     *
     * @return Response
     */
    protected function checkPermissionAndDo(string $permission, callable $treatment): Response {
        $this->denyAccessUnlessGranted($permission, $this->entityClass);
        return $treatment();
    }

    /**
     * @param string                       $permission
     * @param string                       $slug
     * @param QueryMode                    $queryMode
     * @param callable(E $entity):Response $treatment
     *
     * @return Response
     */
    protected function checkPermissionFindEntityAndDo(string $permission, string $slug, QueryMode $queryMode, callable $treatment): Response {
        $this->denyAccessUnlessGranted($permission, $this->entityClass);

        $entity = $this->manager->findOneBySlug($slug, $queryMode);

        if(!$entity) {
            $this->addFlash(MT::ERROR, "Could not find $this->entityClassName \"$slug\", return to list!");
            return $this->redirectToRoute($this->entityClassName . '_List');
        }

        return $treatment($entity);
    }

}
