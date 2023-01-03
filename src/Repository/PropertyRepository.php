<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\Research;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    private const PAGINATOR_PAGES = 9;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Property::class);
        $this->paginator = $paginator;
    }

    public function save(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllVisibleQuery(Research $research): PaginationInterface
    {
        $query = $this->createQueryBuilder('p');

        $query = $this->filter($research, $query);

        return $this->paginator->paginate(
            $query->getQuery(),
            $research->getPage(),
            self::PAGINATOR_PAGES
        );
    }

    /**
     * @param Research $research
     * @param string $field
     * @return int[]
     */
    public function findMinMax(Research $research, string $field): array
    {
        $query = $this->createQueryBuilder('p');

        $query = $this->filter($research, $query, true);

        $result = $query->select("MIN(p.$field) as min, MAX(p.$field) as max")
            ->getQuery()
            ->getScalarResult();

        return [(int) $result[0]['min'], (int) $result[0]['max']];
    }

    /**
     * @param Research $research
     * @param QueryBuilder $query
     * @return QueryBuilder
     */
    public function filter(Research $research, QueryBuilder $query, bool $ignoreRanges = false): QueryBuilder
    {
        if ($research->getSearch()) {
            $query = $query
                ->andWhere('p.title LIKE :search')
                ->setParameter('search', "%{$research->getSearch()}%");
        }

        if ($research->getCity()) {
            $query
                ->andWhere('p.city = :city')
                ->setParameter('city', $research->getCity());
        }

        if ($research->getZipCode()) {
            $query
                ->andWhere('p.zipCode = :zipCode')
                ->setParameter('zipCode', $research->getZipCode());
        }

        if ($research->getSurfaceMin() && !$ignoreRanges) {
            $query
                ->andWhere('p.surface >= :surfaceMin')
                ->setParameter('surfaceMin', $research->getSurfaceMin());
        }

        if ($research->getSurfaceMax() && !$ignoreRanges) {
            $query
                ->andWhere('p.surface <= :surfaceMax')
                ->setParameter('surfaceMax', $research->getSurfaceMax());
        }

        if ($research->getPriceMin() && !$ignoreRanges) {
            $query
                ->andWhere('p.price >= :priceMin')
                ->setParameter('priceMin', $research->getPriceMin());
        }

        if ($research->getPriceMax() && !$ignoreRanges) {
            $query
                ->andWhere('p.price <= :priceMax')
                ->setParameter('priceMax', $research->getPriceMax());
        }

        if ($research->getType()) {
            $query
                ->andWhere('p.type = :type')
                ->setParameter('type', $research->getType());
        }

        if ($research->getCategory()) {
            $query
                ->andWhere('p.category = :category')
                ->setParameter('category', $research->getCategory());
        }
        return $query;
    }

    public function findTypeCount() : array
    {
        return $this->createQueryBuilder('p')
            ->select("COUNT(p.type) as count, p.type")
            ->groupBy('p.type')
            ->getQuery()
            ->getScalarResult();
    }

    public function findThreeRandom()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('RAND()')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}
