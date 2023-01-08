<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Property;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class Stats
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Count of users with role USER
     * @return int
     */
    public function getUsersCount(): int
    {
        return $this->entityManager->getRepository(User::class)->count([]);
    }

    /**
     * Count of properties
     * @return int
     */
    public function getPropertiesCount(): int
    {
        return $this->entityManager->getRepository(Property::class)->count([]);
    }

    public function getFavoriesCategories(): int{
        $entityManager = $this->entityManager->getRepository(Category::class);

        $query = $entityManager->createQuery(
          '  select distinct c.name, count(c.id) from App/Entity/Category c, App/Entity/property p, App/Entity/user_property u
where c.id = p.category_id
        and u.property_id = p.id
group by c.name DESC;'
        );

        // returns an array of Product objects
        return $query->getResult();
    }
}