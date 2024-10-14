<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '', name: 'main_')]
class MainController extends AbstractController
{
    #[Route(path: '', name: 'home')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig');
    }

    #[Route(path: '/test', name: 'test')]
    public function test(): Response
    {
        return $this->render('main/test.html.twig');
    }
}
