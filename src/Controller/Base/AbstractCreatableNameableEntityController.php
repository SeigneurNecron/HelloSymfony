<?php

declare(strict_types = 1);

namespace App\Controller\Base;

use App\Constant\EntityPermission as EP;
use App\Constant\MessageType as MT;
use App\Entity\Base\AbstractNameableEntity;
use App\Enum\QueryMode;
use App\Exception\SecretValidationFailedException;
use App\Form\Entity\EntityDeletionType;
use App\Util\EntityDeletionInfo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Exception\ValidationFailedException;

/**
 * @template E
 * @template F
 * @template-extends AbstractEntityController<E, F>
 */
abstract class AbstractCreatableNameableEntityController extends AbstractNameableEntityController {

    #[Route(path: '/Create', name: 'Create')]
    public function create(Request $request): Response {
        return $this->checkPermissionAndDo(
            EP::CREATE,
            function() use ($request) {
                /**
                 * @var E $entity
                 */
                $entity = $this->manager->newEntity();
                $form   = $this->createForm($this->formClass, $entity, ['submitButtonLabel' => "Create"]);
                $form->handleRequest($request);

                if($form->isSubmitted()) {
                    if($form->isValid()) {
                        try {
                            $this->manager->create($entity);
                            $this->addFlash(MT::SUCCESS, "$this->entityClassName \"{$entity->getName()}\" created!");
                            return $this->redirectToRoute($this->entityClassName . '_Create');
                        }
                        catch(ValidationFailedException $e) {
                            $this->addFlash(MT::ERROR, $e->getMessage());
                        }
                        catch(SecretValidationFailedException $e) {
                            $this->addFlash(MT::ERROR, "Something went wrong. $this->entityClassName update failed!");
                        }
                    }
                    else {
                        $this->addFlash(MT::ERROR, "$this->entityClassName creation failed!");
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

    #[Route(path: '/{slug}/Delete', name: 'Delete', requirements: ['slug' => '[a-zA-Z0-9]+'])]
    public function delete(string $slug, Request $request): Response {
        return $this->checkPermissionFindEntityAndDo(
            EP::DELETE, $slug, QueryMode::WithParents, function(AbstractNameableEntity $entity) use ($request) {
            $form         = null;
            $parentFields = new EntityDeletionInfo($entity);

            if($parentFields->canDelete) {
                $form = $this->createForm(EntityDeletionType::class);
                $form->handleRequest($request);

                if($form->isSubmitted()) {
                    if($form->isValid()) {
                        $this->manager->delete($entity);
                        $this->addFlash(MT::SUCCESS, "$this->entityClassName \"{$entity->getName()}\" deleted!");
                        return $this->redirectToRoute($this->entityClassName . '_List');
                    }
                    else {
                        $this->addFlash(MT::ERROR, "$this->entityClassName deletion failed!");
                    }
                }
            }

            return $this->render(
                'Entity/Prefab/Delete.html.twig',
                [
                    'type'         => $this->entityClassName,
                    'entity'       => $entity,
                    'form'         => $form,
                    'parentFields' => $parentFields,
                ],
            );
        },
        );
    }

}
