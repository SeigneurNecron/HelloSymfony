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
        $entity = $this->repository->find($id);
        return $this->render($this->entityName . '/Details.html.twig', ["entity" => $entity, "type" => $this->entityName]);
    }

    #[Route(path: '/Create', name: 'Create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response {
        $entity = $this->newEntity();
        $form = $this->createForm($this->formClass, $entity);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $this->onCreateSubmission($entity);

            if($form->isValid()) {
                $entityManager->persist($entity);
                $entityManager->flush();
                $this->addFlash('success', $this->entityName . ' created!');
            } else {
                $this->addFlash('error', $this->entityName . ' creation failed!');
            }

            return $this->redirectToRoute($this->entityName . '_Create');
        }

        return $this->render('Prefab/Edit.html.twig', ["form" => $form->createView(), "type" => $this->entityName, "new" => true]);
    }

    #[Route(path: '/Edit/{id}', name: 'Edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response {
        $entity = $this->repository->find($id);
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

        return $this->render('Prefab/Edit.html.twig', ["form" => $form->createView(), "type" => $this->entityName, "new" => false]);
    }

}
