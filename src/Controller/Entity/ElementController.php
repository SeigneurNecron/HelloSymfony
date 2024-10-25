<?php

declare(strict_types = 1);

namespace App\Controller\Entity;

use App\Controller\Base\AbstractCreatableEntityController;
use App\Entity\Element;
use App\Form\Entity\ElementType;
use App\Repository\ElementRepository;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/Element', name: 'Element_')]
class ElementController extends AbstractCreatableEntityController {

    public function __construct(ElementRepository $repository) {
        parent::__construct(Element::class, ElementType::class, $repository);
    }

}
