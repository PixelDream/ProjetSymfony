<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Property;
use App\Entity\User;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use PDO;

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

    /**
     * Sort categories by number of properties in each category and his best favorite property
     * @return array
     * @throws Exception
     */
    public function getFavoriesCategories(): array
    {
        $sql = "
            SELECT category.name AS c, COUNT(user_property.property_id) AS num_properties
            FROM category
            INNER JOIN property
            ON category.id = property.category_id
            INNER JOIN user_property
            ON property.id = user_property.property_id
            GROUP BY c
            ORDER BY num_properties DESC;
        ";

        return $this->entityManager->getConnection()->prepare($sql)->executeQuery()->fetchAllAssociative();
    }

    /**
     * Sort categories by department and number of properties in each category
     * @return array
     */
    public function getPropertiesByDepartment(): array
    {
        $sql = "
            select p.title, count(u.property_id) as 'count', SUBSTRING(p.zip_code, 1, 2) as 'DEP' from property p, user_property u
            where p.id = u.property_id
            group by DEP;

        ";

        return $this->entityManager->getConnection()->prepare($sql)->executeQuery()->fetchAllAssociative();
    }
}