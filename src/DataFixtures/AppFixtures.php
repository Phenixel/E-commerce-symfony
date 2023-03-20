<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
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

    // ...
    public function load(ObjectManager $manager)
    {
        $tabAdmin = ['phen@samsung.fr'];

        foreach ($tabAdmin as $mail){
            $user = new User();
            $user->setEmail($mail);

//            Ajout de rôle
            $user->setRoles(["ROLE_ADMIN"]);

            $password = $this->hasher->hashPassword($user, 'azerty');
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();
        }

        $tabuser = ['user@samsung.fr'];

        foreach ($tabuser as $mail){
            $user = new User();
            $user->setEmail($mail);

//            Ajout de rôle
            $user->setRoles(["ROLE_USER"]);

            $password = $this->hasher->hashPassword($user, 'azerty');
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();
        }

        $tabCateg = ['Smartphone, Tablette, Montre, TV'];

        foreach ($tabCateg as $categ){
            $cat = new Categorie();
            $cat->setTitre($categ);

            $manager->persist($user);
            $manager->flush();
        }

        $tabNames = [
            ''
        ];

        foreach ($tabNames as $categ){
            $cat = new Categorie();
            $cat->setTitre($categ);

            $manager->persist($user);
            $manager->flush();
        }
    }
}
