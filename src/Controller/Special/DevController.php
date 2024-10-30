<?php

namespace App\Controller\Special;

use App\Constant\MessageType as MT;
use App\Constant\UserRole as UR;
use App\Entity\Final\User;
use App\Form\Special\CreateFirstAdminType;
use App\Repository\Final\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/Dev', name: 'Dev_', condition: "env('APP_ENV') === 'dev'")]
class DevController extends AbstractController {

    #[Route(path: '', name: 'Home')]
    public function home(): Response {
        return $this->render('Dev/Home.html.twig');
    }

    #[Route(path: '/FirstAdmin', name: 'FirstAdmin')]
    public function firstAdmin(Request $request, UserRepository $repository, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response {
        $form = $this->createForm(CreateFirstAdminType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {
                try {
                    $username = $this->getParameter('App.Default.FirstAdmin.Username');
                    $email = $this->getParameter('App.Default.FirstAdmin.Email');
                    $password = $this->getParameter('App.Default.FirstAdmin.Password');

                    $user = $repository->findOneByUsernameOrEmail($username, $email);

                    if($user) {
                        if(!$form->getData()['updateIfExists']) {
                            throw new Exception("Default admin already exists.");
                        }
                    }
                    else {
                        $user = new User();
                    }

                    $user->setUsername($username)
                        ->setEmail($email)
                        ->setPassword($hasher->hashPassword($user, $password))
                        ->setRoles([UR::ROLE_ADMIN])
                        ->setVerified(true);
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $this->addFlash(MT::SUCCESS, "Default admin created!");
                    return $this->redirectToRoute('Dev_Home');
                }
                catch(Exception $e) {
                    $this->addFlash(MT::ERROR, $e->getMessage());
                    return $this->redirectToRoute('Dev_FirstAdmin');
                }
            }
            else {
                $this->addFlash(MT::ERROR, "Form validation failed!");
            }
        }

        return $this->render('Dev/FirstAdmin.html.twig', ['form' => $form]);
    }

}
