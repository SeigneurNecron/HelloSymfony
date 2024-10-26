<?php

namespace App\Controller;

use App\Form\Special\LogInType;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '', name: 'Security_')]
class SecurityController extends AbstractController {

    #[Route(path: '/Login', name: 'Login')]
    public function login(AuthenticationUtils $authenticationUtils): Response {
        $lastAuthError = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LogInType::class, options: ['lastUsername' => $lastUsername]);
        return $this->render('Security/Login.html.twig', ['form' => $form, 'lastAuthError' => $lastAuthError,]);
    }

    #[Route(path: '/Logout', name: 'Logout')]
    public function logout(): void {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}
