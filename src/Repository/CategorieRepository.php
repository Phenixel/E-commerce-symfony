<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function save(Categorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Categorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getArticleParCateg(int $idCateg){
        $entityManager = $this->getEntityManager();

        // Récupérer la catégorie correspondante à l'id donné
        $categorie = $entityManager->getRepository(Categorie::class)->find($idCateg);

        // Vérifier si la catégorie existe
        if (!$categorie) {
            throw $this->createNotFoundException('La catégorie n\'existe pas');
        }

        // Récupérer la collection d'articles associés à cette catégorie
        $articles = $categorie->getArticles();

        // Initialiser un tableau pour stocker les informations des articles
        $articlesData = [];

        // Boucler sur la collection d'articles pour extraire les informations souhaitées
        foreach ($articles as $article) {
            $articlesData[] = [
                'id' => $article->getId(),
                'titre' => $article->getTitre(),
                'slug' => $article->getSlug(),
                'description' => $article->getDescription(),
                'image' => $article->getImage(),
                'prix' => $article->getPrix(),
                'categorie' => $article->getIdCateg()->getTitre()
            ];
        }

        return $articlesData;
    }


//    /**
//     * @return Categorie[] Returns an array of Categorie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Categorie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
