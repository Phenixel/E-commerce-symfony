<?php

namespace App\DataFixtures;

use App\Entity\Article;
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

        foreach ($tabAdmin as $mail) {
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

        foreach ($tabuser as $mail) {
            $user = new User();
            $user->setEmail($mail);

//            Ajout de rôle
            $user->setRoles(["ROLE_USER"]);

            $password = $this->hasher->hashPassword($user, 'azerty');
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();
        }

        $tabCateg = ['Smartphone', 'Tablette', 'Montre', 'TV'];

        foreach ($tabCateg as $categ) {
            $cat = new Categorie();
            $cat->setTitre($categ);

            $manager->persist($cat);
            $manager->flush();
        }

        $articles = [
            [
                'slug' => 'galaxy_flip',
                'titre' => 'Galaxy flip',
                'description' => 'Le Samsung Galaxy Flip est un smartphone pliable doté d\'un écran AMOLED de 6,7 pouces, d\'un processeur Qualcomm Snapdragon 865 et de 8 Go de RAM.',
                'image' => 'medias/articles/Galaxy_flip.webp',
                'prix' => 1050,
                'idCategorie' => 1
            ],
            [
                'slug' => 'galaxy_fold',
                'titre' => 'Galaxy Fold',
                'description' => 'Le Samsung Galaxy Fold est un smartphone pliable doté d\'un écran AMOLED Flexible de 7,3 pouces, d\'un processeur Qualcomm Snapdragon 855 et de 12 Go de RAM.',
                'image' => 'medias/articles/Galaxy_fold.webp',
                'prix' => 1545,
                'idCategorie' => 1
            ],
            [
                'slug' => 'galaxy_s22',
                'titre' => 'Galaxy S22',
                'description' => 'Le Samsung Galaxy S22 est un smartphone haut de gamme doté d\'un écran AMOLED de 6,2 pouces, d\'un processeur Qualcomm Snapdragon 888 et de 8 Go de RAM.',
                'image' => 'medias/articles/Galaxy_S22.webp',
                'prix' => 834,
                'idCategorie' => 1
            ],
            [
                'slug' => 'galaxy_s22_ultra',
                'titre' => 'Galaxy S22 Ultra',
                'description' => 'Le Samsung Galaxy S22 Ultra est un smartphone haut de gamme doté d\'un écran AMOLED de 6,9 pouces avec une résolution de 1440 x 3200 pixels.',
                'image' => 'medias/articles/Galaxy_S22_ultra.webp',
                'prix' => 1005,
                'idCategorie' => 1
            ]
        ];

        foreach ($articles as $article) {
            $art = new Article();
            $art->setTitre($article['titre']);
            $art->setSlug($article['slug']);
            $art->setDescription($article['description']);
            $art->setImage($article['image']);
            $art->setPrix($article['prix']);

            // Créer une instance de l'entité Categorie correspondante
            $categorie = $manager->getRepository(Categorie::class)->findOneBy(['titre' => $article['idCategorie']]);
            $art->setIdCateg($categorie);

            $manager->persist($art);
            $manager->flush();
        }

    }
}