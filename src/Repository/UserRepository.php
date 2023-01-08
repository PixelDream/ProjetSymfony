<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    public function addPropertyFavorite(string $userID, Property $property): void
    {
        $user = $this->find($userID);

        if ($user) {
            $user->addFavorite($property);

            $this->save($user, true);
        }
    }

    // store in browser cookies passing $request, $key and $value (array)
    private function generateCookie(Request $request, string $key, int $value): Cookie
    {
        $cookie = $request->cookies->get($key);

        if ($cookie) {
            $cookie = json_decode($cookie, true);
            $cookie = array_flip($cookie);

            if (array_key_exists($value, $cookie)) {
                unset($cookie[$value]);
            } else {
                $cookie[$value] = $value;
            }

            $cookie = array_flip($cookie);
        } else {
            $cookie = [$value];
        }

        return new Cookie($key, json_encode($cookie), time() + 3600 * 24 * 30, '/', null, true, false);
    }

    // get from browser cookies passing $request and $key return array
    private function getFromCookies(Request $request, string $key): array
    {
        $cookie = $request->cookies->get($key);

        if (!$cookie) return [];

        return json_decode($cookie, true);
    }

    public function togglePropertyFavorite(?UserInterface $user, Property $property, Request $request, RedirectResponse $response): void
    {
        if ($user) {
            // get User object with id
            if ($user instanceof User) {
                if ($user->getFavorites()->contains($property)) {
                    $user->removeFavorite($property);
                } else {
                    $user->addFavorite($property);
                }

                $this->save($user, true);
            }
        } else {
            // if cookie contains the property id, remove it else add it; if array is empty, remove the cookie
            $cookie = $this->generateCookie($request, 'favorites', $property->getId());

            $response->headers->setCookie($cookie);

            if (empty(json_decode($cookie->getValue()))) {
                $response->headers->clearCookie('favorites');
            }
        }
    }

    public function getFavorites(?UserInterface $user, Request $request): array
    {
        if ($user instanceof User) {
            return $user->getFavorites()->map(fn (Property $property) => $property->getId())->toArray();
        } else {
            $cookie = $this->getFromCookies($request, 'favorites');

            return $cookie;
        }

        return [];
    }

    public function copyFavoryCookieToUserFavory(?UserInterface $getUser, Request $request, Response $response)
    {
        if ($getUser instanceof User) {
            $cookie = $this->getFromCookies($request, 'favorites');

            if ($cookie) {
                $properties = $this->getEntityManager()->getRepository(Property::class)->findBy(['id' => $cookie]);

                foreach ($properties as $property) {
                    $getUser->addFavorite($property);
                }

                $this->save($getUser, true);

                // remove cookie
                $response->headers->clearCookie('favorites');
            }
        }
    }

    // all users if has favorites
    public function findAllWithFavory(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.favorites IS NOT EMPTY')
            ->getQuery()
            ->getResult();
    }


}
