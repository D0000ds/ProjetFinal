<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function moyennes(){
        $entityManager = $this->getEntityManager(); // get the EntityManager
        $queryBuilder = $entityManager->createQueryBuilder();

        $query = $queryBuilder
            ->select('a.id as article_id, AVG(av.note) as moyenne_note')
            ->from('App\Entity\Article', 'a')
            ->join('a.avis', 'av')
            ->groupBy('a.id')
            ->getQuery();

        $results = $query->getResult();

        return $results;
    }
}
