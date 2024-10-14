<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/characters', name: 'characters_')]
class CharactersController extends AbstractController
{
    #[Route(path: '', name: 'list')]
    public function list(): Response
    {
        return $this->render('characters/list.html.twig');
    }

    #[Route(path: '/create', name: 'create')]
    public function create(): Response
    {
        return $this->render('characters/create.html.twig');
    }

    #[Route(path: '/details/{id}', name: 'details')]
    public function details(int $id): Response
    {
        return $this->render('characters/details.html.twig', compact('id'));
    }
}
