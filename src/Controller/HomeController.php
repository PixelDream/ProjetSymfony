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

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('hello/about.html.twig');
    }

    #[Route('/annonces', name: 'annonces')]
    public function annonces(): Response
    {
        return $this->render('hello/annonce.html.twig');
    }

    #[Route('/client', name: 'client')]
    public function client(): Response
    {
        return $this->render('hello/client.html.twig');
    }

    #[Route('/conditions', name: 'conditions')]
    public function condition(): Response
    {
        return $this->render('hello/condition.html.twig');
    }


    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('hello/contact.html.twig');

    }

    #[Route('/politique', name: 'politique')]
    public function politique(): Response
    {
        return $this->render('hello/politique.html.twig');
    }


}
