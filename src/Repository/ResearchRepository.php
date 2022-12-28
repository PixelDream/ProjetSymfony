<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\Research;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * @extends ServiceEntityRepository<Research>
 *
 * @method Research|null find($id, $lockMode = null, $lockVersion = null)
 * @method Research|null findOneBy(array $criteria, array $orderBy = null)
 * @method Research[]    findAll()
 * @method Research[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResearchRepository extends ServiceEntityRepository
{
    private LoggerInterface $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Research::class);
        $this->logger = $logger;
    }

    public function save(Research $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Research $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Research[] Returns an array of Research objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Research
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @param Property $property
     * @return array<Research>
     */
    public function findBySameProperty(Property $property) : array
    {
        $query = $this->createQueryBuilder('r');

        $query->andWhere('r.city = :city OR r.city IS NULL')
            ->setParameter('city', $property->getCity());

        $query->andWhere('r.zipCode = :zipCode OR r.zipCode IS NULL')
            ->setParameter('zipCode', $property->getZipCode());

        $query->andWhere('r.type = :type OR r.type IS NULL')
            ->setParameter('type', $property->getType());

        $query->andWhere('r.category = :category OR r.category IS NULL')
            ->setParameter('category', $property->getCategory());

        // 0 <= 50
        $query->andWhere('r.surfaceMin <= :surface OR r.surfaceMin IS NULL')
            ->setParameter('surface', $property->getSurface());

        // 100 >= 50
        $query->andWhere('r.surfaceMax >= :surface OR r.surfaceMax IS NULL')
            ->setParameter('surface', $property->getSurface());

        $query->andWhere('r.priceMin <= :price OR r.priceMin IS NULL')
            ->setParameter('price', $property->getPrice());

        $query->andWhere('r.priceMax >= :price OR r.priceMax IS NULL')
            ->setParameter('price', $property->getPrice());

        var_dump($query->getQuery()->getSQL());

        // fetch all emails of query
        return $query->getQuery()->getResult();
    }
}
