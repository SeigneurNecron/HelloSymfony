<?php

namespace App\Service\Security;

use App\Entity\Final\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

readonly class EmailVerifier {

    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface            $mailer,
        private EntityManagerInterface     $entityManager,
    ) {}

    /**
     * @throws TransportExceptionInterface
     */
    public function sendVerificationEmail(User $user): void {
        $email = (new TemplatedEmail())
            ->from(new Address('support@hellosymfony.com', 'Support'))
            ->to((string) $user->getEmail())
            ->subject("Please Confirm your Email")
            ->htmlTemplate('Email/VerificationEmail.html.twig');

        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'Registration_VerifyEmail',
            (string) $user->getId(),
            (string) $user->getEmail(),
        );

        $context                         = $email->getContext();
        $context['signedUrl']            = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey']  = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        $this->mailer->send($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendAlreadyExistsMail(User $user): void {
        $this->mailer->send(
            (new TemplatedEmail())
                ->from(new Address('support@hellosymfony.com', 'Support'))
                ->to((string) $user->getEmail())
                ->subject("You already have an account")
                ->htmlTemplate('Email/AlreadyExistsEmail.html.twig'),
        );
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, User $user): void {
        $this->verifyEmailHelper->validateEmailConfirmationFromRequest($request, (string) $user->getId(), (string) $user->getEmail());

        $user->setVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}
