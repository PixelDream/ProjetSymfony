<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Service\Stats;
use Doctrine\ORM\EntityManager;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\PropertyCrudController;


class DashboardController extends AbstractDashboardController
{

    private Stats $stats;

    public function __construct(Stats $stats)
    {
        $this->stats = $stats;
    }

    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'user_count' => $this->stats->getUsersCount(),
        ]);
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('admin');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ProjetSymfony')
            ->renderContentMaximized(true);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Biens', 'fa fa-list', PropertyCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', UserCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Categories', 'fas fa-user', CategoryCrudController::getEntityFqcn());
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
