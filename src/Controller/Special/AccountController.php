<?php

declare(strict_types = 1);

namespace App\Controller\Special;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/Account', name: 'Account_')]
#[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
class AccountController extends AbstractController {

    #[Route(path: '', name: 'Profile')]
    public function home(): Response {
        return $this->render('Account/Profile.html.twig');
    }

    // TODO if the user is not verified display a message and a button to send a verification mail (in profile page)
    // TODO button to change password (in profile page)

}
