<?php

namespace App\Controller;

use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoryController extends AbstractController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    /**
     * Page de gestion des favoris coté admin
     * @param UserRepository $userRepository
     * @return Response
     */
    #[Route('/admin/favory', name: 'app_favory_index')]
    public function index(UserRepository $userRepository): Response
    {
        // get all user with one or more favory
        $users = $userRepository->findAllWithFavory();

        return $this->render('favory/index.html.twig', [
            'users' => $users,
        ]);
    }

}
