<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CroppedFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $u = (new User())
            ->setRoles(['Administrator'])
            ->setUsername('obama');
        $password = $this->hasher->hashPassword($u, 'Obama0bama');
        $u->setPassword($password);

        $manager->persist($u);

        $manager->flush();
    }
}
