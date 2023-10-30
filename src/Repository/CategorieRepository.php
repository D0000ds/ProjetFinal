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

    public function nbArticleParCategorie()
    {
        $entityManager = $this->getEntityManager(); // get the EntityManager
        $queryBuilder = $entityManager->createQueryBuilder();

        $query = $queryBuilder
            ->select('c.id AS categorie_id, c.libelle AS categorie_nom, COUNT(a.categorie) AS nbArticleCategorie')
            ->from('App\Entity\Categorie', 'c')
            ->leftJoin('c.articles', 'a')
            ->groupBy('c.id, c.libelle')
            ->getQuery();
    

        $result = $query->getResult();

        return $result;
    }
}
