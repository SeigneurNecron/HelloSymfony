<?php

declare(strict_types = 1);

namespace App\Controller\Base;

use App\Constant\EntityPermission as EP;
use App\Constant\MessageType as MT;
use App\Entity\Base\AbstractEntity;
use App\Entity\Base\AbstractNameableEntity;
use App\Enum\QueryMode;
use App\Form\Entity\EntityDeletionType;
use App\Repository\Base\AbstractNameableEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @template E
 * @template F
 * @template R
 * @template-extends AbstractEntityController<E, F, R>
 */
abstract class AbstractCreatableEntityController extends AbstractEntityController {

    protected function __construct(string $entityClass, string $formClass, AbstractNameableEntityRepository $repository) {
        parent::__construct($entityClass, $formClass, $repository);
    }

    #[Route(path: '/Create', name: 'Create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response {
        return $this->checkPermissionAndDo(
            EP::CREATE, function() use ($request, $entityManager) {
            $entity = $this->newEntity();
            $form   = $this->createForm($this->formClass, $entity, ['submitButtonLabel' => "Create"]);
            $form->handleRequest($request);

            if($form->isSubmitted()) {
                if($form->isValid()) {
                    $entityManager->persist($entity);
                    $entityManager->flush();
                    $this->addFlash(MT::SUCCESS, "$this->entityName \"{$entity->getName()}\" created!");
                    return $this->redirectToRoute($this->entityName . '_Create');
                }
                else {
                    $this->addFlash(MT::ERROR, "$this->entityName creation failed!");
                }
            }

            return $this->render('Entity/Prefab/Edit.html.twig', ['type' => $this->entityName, 'entity' => $entity, 'form' => $form]);
        },
        );
    }

    #[Route(path: '/{slug}/Delete', name: 'Delete', requirements: ['slug' => '[a-zA-Z0-9]+'])]
    public function delete(string $slug, Request $request, EntityManagerInterface $entityManager): Response {
        return $this->checkPermissionFindEntityAndDo(
            EP::DELETE, $slug, QueryMode::WithParents, function(AbstractNameableEntity $entity) use ($request, $entityManager) {
            $form          = null;
            $canDelete     = true;
            $emptyFields   = [];
            $lockedFields  = [];
            $cascadeFields = [];

            /** @var OneToMany $attribute */
            foreach($entity->getParentFields() as $parentField => $attribute) {
                $getter = 'get' . ucfirst($parentField);

                /** @var Collection<int, AbstractEntity> $parent */
                $parent = $entity->$getter();

                $count = $parent->count();

                if($count > 0) {
                    if($attribute->orphanRemoval) {
                        $cascadeFields[] = $parentField;
                    }
                    else {
                        $lockedFields[] = $parentField;
                        $canDelete      = false;
                    }
                }
                else {
                    $emptyFields[] = $parentField;
                }
            }

            $parentFields = compact('lockedFields', 'cascadeFields', 'emptyFields');

            if($canDelete) {
                $form = $this->createForm(EntityDeletionType::class);
                $form->handleRequest($request);

                if($form->isSubmitted()) {
                    if($form->isValid()) {
                        $entityManager->remove($entity);
                        $entityManager->flush();
                        $this->addFlash(MT::SUCCESS, "$this->entityName \"{$entity->getName()}\" deleted!");
                        return $this->redirectToRoute($this->entityName . '_List');
                    }
                    else {
                        $this->addFlash(MT::ERROR, "$this->entityName deletion failed!");
                    }
                }
            }

            return $this->render('Entity/Prefab/Delete.html.twig', ['type' => $this->entityName, 'entity' => $entity, 'form' => $form, 'parentFields' => $parentFields]);
        },
        );
    }

}
