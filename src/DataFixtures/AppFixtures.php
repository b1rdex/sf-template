<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $generators = [
            $this->users(),
        ];
        foreach ($generators as $generator) {
            foreach ($generator as $entity) {
                $manager->persist($entity);
            }
            $manager->flush();
        }
    }

    /**
     * @return iterable<User>
     */
    private function users(): iterable
    {
        $users = [
            'admin' => ['ROLE_ADMIN'],
        ];
        foreach ($users as $name => $roles) {
            $user = new User();
            $user->setUsername($name);
            $user->setPassword($this->passwordHasher->hashPassword($user, $name));
            $user->setRoles($roles);

            yield $user;
        }
    }
}
