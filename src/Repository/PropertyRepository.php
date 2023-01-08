<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\Research;
use App\Message\SendPropertiesEmailMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Messenger\MessageBusInterface;

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
    private MessageBusInterface $messageBus;
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator, MessageBusInterface $messageBus)
    {
        parent::__construct($registry, Property::class);
        $this->paginator = $paginator;
        $this->messageBus = $messageBus;
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

    /**
     * Paginate all properties depending on the research.
     * @param Research $research
     * @return PaginationInterface
     */
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
     *  Filter research and return query
     * @param Research $research
     * @param QueryBuilder $query
     * @param bool $ignoreRanges
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

    /**
     * Find min and max price for field passed in args
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

        return [(int)$result[0]['min'], (int)$result[0]['max']];
    }

    /**
     * Find count of type of property
     * @return array
     */
    public function findTypeCount(): array
    {
        return $this->createQueryBuilder('p')
            ->select("COUNT(p.type) as count, p.type")
            ->groupBy('p.type')
            ->getQuery()
            ->getScalarResult();
    }

    /**
     * Get three random properties
     * @return float|int|mixed|string
     */
    public function findThreeRandom()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('RAND()')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    /**
     * Share properties by email
     * @param string $email
     * @param array $favorites
     * @return void
     */
    public function share(string $email, array $favorites): void
    {
        //send email with the list of favorites
        $message = new SendPropertiesEmailMessage($email, $this->findFavorites($favorites));
        $this->messageBus->dispatch($message);
    }

    /**
     * find all properties passed in parameter
     * @param array $favorites
     * @return array
     */
    public function findFavorites(array $favorites): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id IN (:favorites)')
            ->setParameter('favorites', $favorites)
            ->getQuery()
            ->getResult();
    }
}
