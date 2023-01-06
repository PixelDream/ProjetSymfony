<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Research;
use App\Form\ResearchType;
use App\Repository\CategoryRepository;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/', name: 'app')]
    public function index(PropertyRepository $propertyRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $research = new Research();

        $form = $this->createForm(ResearchType::class, $research, [
            'choice_mapper' => $research->getCity(),
            'category_mapper' => $categoryRepository->findAll(),
            'action' => $this->generateUrl('app_property_index'),
        ]);

        return $this->render('hello/index.html.twig', [
            'form' => $form->createView(),
            'properties' => $propertyRepository->findThreeRandom(),
            'categories' => $categoryRepository->findAll()
        ]);

    }
    /* ##[Route('/', name: 'app')]
     public function entit(EntityManagerInterface $entityManager)
     {
         $repository = $this->entityManager->getRepository(Property::class);
             return $this->render('hello/index.html.twig',['properties'=>$properties,
         ]);
     }
     #*/
}
