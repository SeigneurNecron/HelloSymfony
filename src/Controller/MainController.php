<?php

declare(strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '', name: 'Main_')]
class MainController extends AbstractController {

    #[Route(path: '', name: 'Home')]
    public function home(): Response {
        return $this->render('Main/Home.html.twig');
    }

}
