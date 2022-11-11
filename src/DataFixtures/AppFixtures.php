<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('nabile333@live.fr');
        $user->setFirstName('Belhassen');
        $user->setLastName('Bouchoucha');
        $password = $this->hasher->hashPassword($user, '1234');
        $user->setPassword($password);
        $manager->persist($user);

        $user1 = new User();
        $user1->setEmail('admin@live.fr');
        $user1->setFirstName('Karim');
        $user1->setLastName('Karouni');
        $user1->setRoles(['ROLE_ADMIN']);
        $password = $this->hasher->hashPassword($user, '1234');
        $user1->setPassword($password);
        $manager->persist($user1);

        $manager->flush();
    }
}
