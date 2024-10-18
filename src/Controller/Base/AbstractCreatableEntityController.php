<?php

declare(strict_types = 1);

namespace App\Controller\Base;

use App\Repository\Base\AbstractEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    protected function __construct(string $entityClass, string $formClass, AbstractEntityRepository $repository) {
        parent::__construct($entityClass, $formClass, $repository);
    }

    #[Route(path: '/Create', name: 'Create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response {
        $entity = $this->newEntity();
        $form = $this->createForm($this->formClass, $entity, ['submitButtonLabel' => "Create"]);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {
                $entityManager->persist($entity);
                $entityManager->flush();
                $this->addFlash('success', $this->entityName . " created!");
                return $this->redirectToRoute($this->entityName . '_Create');
            }
            else {
                dump("Form validation failed."); // TODO tmp
                dump(get_class($this));
                dd($entity); // TODO tmp
            }
        }

        return $this->render('Prefab/Edit.html.twig', ['type' => $this->entityName, 'entity' => $entity, 'form' => $form->createView()]);
    }

}