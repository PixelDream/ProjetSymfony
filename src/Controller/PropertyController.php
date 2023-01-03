<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Research;
use App\Form\PropertyType;
use App\Form\ResearchType;
use App\Repository\CategoryRepository;
use App\Repository\PropertyRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Orm\EntityPaginatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/property')]
class PropertyController extends AbstractController
{
    #[Route('/', name: 'app_property_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $research = new Research();

        $research->setPage($request->query->getInt('page', 1));

        return $this->researchNow($propertyRepository, $categoryRepository, $request, $research);
    }

    public function researchNow(PropertyRepository $propertyRepository, CategoryRepository $categoryRepository, Request $request, Research $research): Response {
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

    #[Route('/{id}', name: 'app_property_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }

}
