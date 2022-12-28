<?php

namespace App\Controller;

use App\Repository\ResearchRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResearchController extends AbstractController
{

    /**
     * Delete research with passed token
     * @param string $token
     * @param ResearchRepository $researchRepository
     * @return Response
     */
    #[Route('/research/{token}/delete', name: 'app_research_delete')]
    public function index(string $token, ResearchRepository $researchRepository): Response
    {
        $research = $researchRepository->findOneBy(['token' => $token]);
        $researchRepository->remove($research, true);

        return $this->render('research/delete.html.twig');
    }
}
