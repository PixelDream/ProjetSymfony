<?php

namespace App\Service;

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

}