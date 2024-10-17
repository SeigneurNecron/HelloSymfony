<?php

declare(strict_types = 1);

namespace App\Controller;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

abstract class AbstractCreatableEntityController extends AbstractEntityController {

    protected function __construct(string $entityClass, string $formClass, ServiceEntityRepository $repository) {
        parent::__construct($entityClass, $formClass, $repository);
    }

    #[Route(path: '/Create', name: 'Create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response {
        $entity = $this->newEntity();
        $form = $this->createForm($this->formClass, $entity, ['submitButtonLabel' => 'Create']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entity);
            $entityManager->flush();
            $this->addFlash('success', $this->entityName . ' created!');
            return $this->redirectToRoute($this->entityName . '_Create');
        }

        return $this->render('Prefab/Edit.html.twig', ["form" => $form->createView(), "type" => $this->entityName, "new" => true]);
    }

}
