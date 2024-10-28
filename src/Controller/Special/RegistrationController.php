<?php

namespace App\Controller\Special;

use App\Constants\MessageType as MT;
use App\Entity\Final\User;
use App\Form\Special\RegistrationType;
use App\Security\Registration\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[Route(path: '', name: 'Registration_')]
class RegistrationController extends AbstractController {

    public function __construct(
        private readonly EmailVerifier $emailVerifier
    ) {}

    #[Route('/Register', name: 'Register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {
                /** @var string $plainPassword */
                $plainPassword = $form->get('plainPassword')->getData();
                $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
                $entityManager->persist($user);
                $entityManager->flush();

                try {
                    $this->emailVerifier->sendEmailConfirmation('Registration_VerifyEmail', $user,
                        (new TemplatedEmail())
                            ->from(new Address('support@hellosymfony.com', 'Support'))
                            ->to((string)$user->getEmail())
                            ->subject("Please Confirm your Email")
                            ->htmlTemplate('/Security/ConfirmationEmail.html.twig')
                    );
                    $this->addFlash(MT::INFO, 'Please check your emails and use the link to verify your account.');
                }
                catch(TransportExceptionInterface $e) {
                    $this->addFlash(MT::WARNING, 'Something went wrong while sending the verification email. You can ask for another one in your profile.');
                }

                $this->addFlash(MT::SUCCESS, 'Registration Successful!');
                return $security->login($user, 'form_login', 'main');
            }
            else {
                $this->addFlash(MT::ERROR, "Registration failed!");
            }
        }

        return $this->render('/Security/Register.html.twig', ['form' => $form]);
    }

    #[Route('/VerifyEmail', name: 'VerifyEmail')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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

}
