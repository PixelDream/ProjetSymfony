<?php

namespace App\Controller;

use App\Form\AccountType;
use App\Form\SharePropertyType;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountController
 * @package App\Controller
 */
class AccountController extends AbstractController
{
    /**
     * Compte utilisateur
     * @param UserRepository $userRepository
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordEncoder
     * @return Response
     */
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

    /**
     * Partage d'une propriété par email
     * @param PropertyRepository $propertyRepository
     * @param Request $request
     * @return Response
     */
    #[Route('/favory', name: 'app_favory')]
    #[Route('/account/favory', name: 'app_account_favory')]
    public function favory(UserRepository $userRepository, PropertyRepository $propertyRepository, Request $request): Response
    {
        $favorites = $userRepository->getFavorites($this->getUser(), $request);
        $favorites = $propertyRepository->findFavorites($favorites);

        // return form SharePropertyType
        $form = $this->createForm(SharePropertyType::class, null, [
            'email' => $this->getUser() ? $this->getUser()->getEmail() : null,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // call share with email property
            $propertyRepository->share($form->get('email')->getData(), $userRepository->getFavorites($this->getUser(), $request));

            $this->addFlash('success', 'Votre email a bien été envoyé');
        }

        return $this->render('account/favory.html.twig', [
            'favorites' => $favorites,
            'form' => $form->createView(),
        ]);
    }
}
