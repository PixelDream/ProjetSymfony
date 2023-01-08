<?php

namespace App\Controller\Admin;

use App\Service\Stats;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
            'property_count' => $this->stats->getPropertiesCount(),
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
            ->setTitle('ProjetSymfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour au site', 'fa fa-undo', 'app');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Biens', 'fa fa-list', PropertyCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', UserCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Catégories', 'fas fa-tags', CategoryCrudController::getEntityFqcn());
        yield MenuItem::linkToRoute('Favoris', 'fas fa-heart', 'app_favory_index');
    }
}
