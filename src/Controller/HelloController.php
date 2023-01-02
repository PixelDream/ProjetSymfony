<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/', name: 'app')]
    public function index(EntityManagerInterface $em, CategoryRepository $categoryRepository): Response
    {
        $this->addFlash('warning', 'HelloWorld!');
        $properties = [];
        $sql = 'SELECT * from property ORDER BY RAND() LIMIT 3';
        //$em = this->getEnti;
        $statement = $em->getConnection()->prepare($sql);
        $result = $statement->execute()->fetchAll();
        foreach ($result as $key => $value) {
            $property = new Property();
            $property->setCategory($categoryRepository->findOneBy(array('id' => $value['category_id'])));
            $property->setTitle($value['title']);
            $property->setUpdatedAt(\DateTimeImmutable::createFromMutable(new \DateTime($value['updated_at'])));

            $properties[] = $property;
        }


        return $this->render('hello/index.html.twig',
            [  'controller_name' => 'HelloController', 'properties' => $properties, 'categories' => $categoryRepository->findAll()]);

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
