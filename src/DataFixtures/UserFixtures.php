<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Créer 5 utilisateurs dont un avec le rôle admin
        for ($i = 0; $i < 4; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@safer.com');
            $user->setFirstName('John ' . $i);
            $user->setLastName('Doe');
            $user->setIsVerified($i != 3);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $manager->persist($user);
        }

        $admin = new User();
        $admin->setEmail('admin@safer.com');
        $admin->setFirstName('John Admin');
        $admin->setLastName('Doe');
        $admin->setIsVerified(true);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'password'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $manager->flush();
    }
}
