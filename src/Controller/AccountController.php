<?php

namespace App\Controller;

use App\Form\AccountType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(UserRepository $userRepository, Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        // return form AccountType
        $form = $this->createForm(AccountType::class, $this->getUser());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get('password')->isEmpty()) {
                $this->getUser()->setPassword($passwordEncoder->hashPassword($this->getUser(), $form->get('password')->getData()));
            }

            $userRepository->save($this->getUser(), true);

            $this->addFlash('success', 'Votre compte a bien été mis à jour');
        }

        return $this->render('account/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/account/favory', name: 'app_account_favory')]
    public function favory(): Response
    {
        return $this->render('account/favory.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }
}
