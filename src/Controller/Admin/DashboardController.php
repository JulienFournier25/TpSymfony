<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Project;
use App\Entity\Technology;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('My Project');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Categories', 'fas fa-tags', Category::class);
        yield MenuItem::linkToCrud('Technologies', 'fas fa-lightbulb', Technology::class);
        yield MenuItem::linkToCrud('Projects', 'fas fa-rocket', Project::class);
    }
}
