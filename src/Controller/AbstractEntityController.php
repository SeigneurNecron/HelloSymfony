<?php

declare(strict_types = 1);

namespace App\Controller;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

abstract class AbstractEntityController extends AbstractController {

    protected readonly string $entityName;

    protected function __construct(protected readonly string                  $entityClass,
                                   protected readonly string                  $formClass,
                                   protected readonly ServiceEntityRepository $repository) {
        $splitClass = explode('\\', $entityClass);
        $this->entityName = $splitClass[count($splitClass) - 1];
    }

    protected abstract function newEntity(): object;

    protected function find(int $id): object {
        return $this->repository->find($id);
    }

    protected function onCreateSubmission(object $entity): void {
    }

    protected function onEditSubmission(object $entity): void {
    }

    #[Route(path: '', name: 'List')]
    public function list(): Response {
        $entities = $this->repository->findBy([], ['name' => 'ASC']);
        return $this->render('Prefab/List.html.twig', ["entities" => $entities, "type" => $this->entityName]);
    }

    #[Route(path: '/Details/{id}', name: 'Details')]
    public function details(int $id): Response {
        // TODO find by name instead of id
        $entity = $this->find($id);
        return $this->render($this->entityName . '/Details.html.twig', ["entity" => $entity, "type" => $this->entityName]);
    }

    #[Route(path: '/Edit/{id}', name: 'Edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response {
        // TODO maybe find by name instead of id, but that might cause issues if the entity is renamed
        $entity = $this->find($id);
        $form = $this->createForm($this->formClass, $entity);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $this->onEditSubmission($entity);

            if($form->isValid()) {
                $entityManager->persist($entity);
                $entityManager->flush();
                $this->addFlash('success', $this->entityName . ' updated!');
                return $this->redirectToRoute($this->entityName . '_Details', ["id" => $id]);
            } else {
                $this->addFlash('error', $this->entityName . ' update failed!');
                return $this->redirectToRoute($this->entityName . '_Edit', ["id" => $id]);
            }
        }

        return $this->render('Prefab/Edit.html.twig', ["entity" => $entity, "form" => $form->createView(), "type" => $this->entityName, "new" => false]);
    }

}
