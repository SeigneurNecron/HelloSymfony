<?php

namespace App\Controller\Special;

use App\Constant\MessageType as MT;
use App\Entity\Final\User;
use App\Exception\SecretValidationFailedException;
use App\Form\Special\RegistrationType;
use App\Security\Registration\EmailVerifier;
use App\Service\Entity\Final\UserManager;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[Route(path: '', name: 'Registration_')]
class RegistrationController extends AbstractController {

    public function __construct(
        private readonly EmailVerifier   $emailVerifier,
        private readonly MailerInterface $mailer,
    ) {}

    #[Route('/Register', name: 'Register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, UserManager $userManager): Response {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {
                /** @var string $plainPassword */
                $plainPassword = $form->get('plainPassword')->getData();
                $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

                try {
                    $userManager->create($user);
                    $this->sendVerificationEmail($user, false);
                    $this->addFlash(MT::SUCCESS, 'Registration Successful!');
                    return $security->login($user, 'form_login', 'main');
                }
                catch(SecretValidationFailedException $e) {
                    $this->sendVerificationEmail($user, true);
                    return $this->redirectToRoute('Main_Home');
                }
                catch(ValidationFailedException $e) {
                    $this->addFlash(MT::ERROR, $e->getMessage());
                }
            }
            else {
                $this->addFlash(MT::ERROR, "Registration failed!");
            }
        }

        return $this->render('/Security/Register.html.twig', ['form' => $form]);
    }

    #[Route('/VerifyEmail', name: 'VerifyEmail')]
    #[IsGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY)]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response {
        try {
            /** @var User $user */
            $user = $this->getUser();
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        }
        catch(VerifyEmailExceptionInterface $exception) {
            $this->addFlash(MT::ERROR, $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));
            return $this->redirectToRoute('Registration_Register');
        }

        $this->addFlash(MT::SUCCESS, "Your email address has been verified.");
        return $this->redirectToRoute('Main_Home');
    }

    private function sendVerificationEmail(User $user, bool $alreadyExists): void {
        try {
            if($alreadyExists) {
                $this->mailer->send(
                    (new TemplatedEmail())
                        ->from(new Address('support@hellosymfony.com', 'Support'))
                        ->to((string) $user->getEmail())
                        ->subject("You already have an account")
                        ->htmlTemplate('Email/AlreadyExistsEmail.html.twig'),
                );
            }
            else {
                $this->emailVerifier->sendEmailConfirmation(
                    'Registration_VerifyEmail',
                    $user,
                    (new TemplatedEmail())
                        ->from(new Address('support@hellosymfony.com', 'Support'))
                        ->to((string) $user->getEmail())
                        ->subject("Please Confirm your Email")
                        ->htmlTemplate('Email/VerificationEmail.html.twig'),
                );
            }

            $this->addFlash(MT::INFO, 'Please check your emails.');
        }
        catch(TransportExceptionInterface $e) {
            $this->addFlash(MT::WARNING, 'Something went wrong while sending the verification email. You can ask for another one in your profile.');
        }
    }

    // TODO add a profile page
    // TODO if the user is not verified display a message and a button to send a verification mail (in profile page)
    // TODO button to change password (in profile page)

}
