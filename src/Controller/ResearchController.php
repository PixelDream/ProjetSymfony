<?php

namespace App\Controller;

use App\Entity\Research;
use App\Form\ContactResearchType;
use App\Repository\CategoryRepository;
use App\Repository\ResearchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        $this->addFlash('success', 'Votre recherche a bien été supprimée');

        return $this->redirectToRoute('app');
    }

    /**
     * Create a new research from form
     * @param Request $request
     * @param ResearchRepository $researchRepository
     * @return Response
     */
    #[Route('/research/create', name: 'app_research_create')]
    public function create(Request $request, ResearchRepository $researchRepository, CategoryRepository $categoryRepository): Response
    {
        $research = new Research();
        $user = $this->getUser();

        if ($user) $research->setEmail($user->getEmail());

        $form = $this->createForm(ContactResearchType::class, $research, [
            'choice_mapper' => $research->getCity(),
            'category_mapper' => $categoryRepository->findAll(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $researchRepository->save($research, true);
            $this->addFlash('success', 'Votre alerte a bien été enregistrée');

            return $this->redirectToRoute('app_research_create');
        }

        return $this->render('research/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
