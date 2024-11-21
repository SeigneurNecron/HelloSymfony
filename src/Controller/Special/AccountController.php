<?php

declare(strict_types = 1);

namespace App\Controller\Special;

use App\Constant\MessageType as MT;
use App\Entity\Final\User;
use App\Form\Special\SendVerificationMailType;
use App\Service\Security\EmailVerifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/Account', name: 'Account_')]
#[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
class AccountController extends AbstractController {

    public function __construct(
        private readonly EmailVerifier $emailVerifier,
    ) {}

    #[Route(path: '', name: 'Profile')]
    public function profile(Request $request): Response {
        /** @var User $user */
        $user = $this->getUser();
        $form = null;

        if(!$user->isVerified()) {
            $form = $this->createForm(SendVerificationMailType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                try {
                    $this->emailVerifier->sendVerificationEmail($user);
                    $this->addFlash(MT::SUCCESS, 'Email sent. Please check your emails.');
                }
                catch(TransportExceptionInterface $e) {
                    $this->addFlash(MT::WARNING, 'Something went wrong while sending the verification email. Please try again later.');
                }

                return $this->redirectToRoute('Account_Profile');
            }
        }

        return $this->render('Account/Profile.html.twig', ['form' => $form]);
    }

}
