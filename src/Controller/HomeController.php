<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();

        return $this->render('home/index.html.twig', [
            'projects' => $projects,
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/project/{id}', name: 'project_show')]
    public function show(int $id, ProjectRepository $projectRepository): Response
    {
        $project = $projectRepository->find($id);

        if (!$project) {
            throw $this->createNotFoundException('The project does not exist');
        }

        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }
}
