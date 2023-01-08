<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Research;
use App\Form\ResearchType;
use App\Repository\CategoryRepository;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/property')]
class PropertyController extends AbstractController
{
    /**
     * Page de recherche de biens
     * @param PropertyRepository $propertyRepository
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'app_property_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $research = new Research();

        $research->setPage($request->query->getInt('page', 1));

        return $this->researchNow($propertyRepository, $categoryRepository, $request, $research);
    }

    /**
     * Function de recherche de biens
     * @param PropertyRepository $propertyRepository
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @param Research $research
     * @return Response
     */
    public function researchNow(PropertyRepository $propertyRepository, CategoryRepository $categoryRepository, Request $request, Research $research): Response
    {
        $form = $this->createForm(ResearchType::class, $research, [
            'choice_mapper' => $research->getCity(),
            'category_mapper' => $categoryRepository->findAll(),
        ]);

        $form->handleRequest($request);

        [$minSurface, $maxSurface] = $propertyRepository->findMinMax($research, 'surface');
        [$minPrice, $maxPrice] = $propertyRepository->findMinMax($research, 'price');

        return $this->render('property/index.html.twig', [
            'research' => $research,
            'properties' => $propertyRepository->findAllVisibleQuery($research),
            'categories' => $categoryRepository->findAll(),
            'row' => $request->query->getBoolean('row'),
            'form' => $form->createView(),
            'surface' => [
                'min' => $minSurface,
                'max' => $maxSurface,
            ],
            'price' => [
                'min' => $minPrice,
                'max' => $maxPrice,
            ],
            'types' => $propertyRepository->findTypeCount(),
        ]);
    }

    /**
     * Page de détail d'un bien
     * @param Property $property
     * @param UserRepository $userRepository
     * @param Request $request
     * @return Response
     */
    #[Route('/{id}', name: 'app_property_show', methods: ['GET'])]
    public function show(Property $property, UserRepository $userRepository, Request $request): Response
    {
        $userFavorites = $userRepository->getFavorites($this->getUser(), $request);

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'userFavorites' => $userFavorites
        ]);
    }

    /**
     * Page de création d'un favoris sur un bien
     * @param Property $property
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    #[Route('/{id}/add', name: 'app_property_add_favorite')]
    public function addFavorite(Property $property, Request $request, UserRepository $userRepository): Response
    {
        $response = $this->redirectToRoute('app_property_show', ['id' => $property->getId()]);

        $userRepository->togglePropertyFavorite($this->getUser(), $property, $request, $response);

        $this->addFlash('success', 'La propriété a bien été ajoutée aux favoris');

        return $response;
    }

    /**
     * Page de suppression d'un favoris sur un bien
     * @param Property $property
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    #[Route('/{id}/remove', name: 'app_property_remove_favorite')]
    public function removeFavorite(Property $property, Request $request, UserRepository $userRepository): Response
    {
        $response = $this->redirectToRoute('app_property_show', ['id' => $property->getId()]);

        $userRepository->togglePropertyFavorite($this->getUser(), $property, $request, $response);

        $this->addFlash('success', 'La propriété a bien été retirée des favoris');

        return $response;
    }

    /**
     * Page de suppression d'un favoris sur un bien
     * @param Request $request
     * @return Response
     */
    #[Route('/{id}/favorite', name: 'app_property_delete_favorite')]
    public function deleteFavorite(Property $property, Request $request, UserRepository $userRepository): Response
    {
        if (count($userRepository->getFavorites($this->getUser(), $request)) == 1) {
            $response = $this->redirectToRoute('app');
            $this->addFlash('warning', 'Vous n\'avez plus de favoris');
        } else {
            if ($this->getUser()) {
                $response = $this->redirectToRoute('app_account_favory');
            } else {
                $response = $this->redirectToRoute('app_favory');
            }
        }

        $userRepository->togglePropertyFavorite($this->getUser(), $property, $request, $response);

        return $response;
    }
}