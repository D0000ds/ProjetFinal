<?php

namespace App\Repository;

use App\Entity\Avis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Avis>
 *
 * @method Avis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avis[]    findAll()
 * @method Avis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avis::class);
    }

    public function nbAvisEtCommentaire($id){
        $entityManager = $this->getEntityManager(); // get the EntityManager
        $queryBuilder = $entityManager->createQueryBuilder();

        $query = $queryBuilder
            ->select('COUNT(av.id) AS nbAvis, COUNT(av.commentaire) AS nbCommentaire')
            ->from('App\Entity\Article', 'a')
            ->join('a.avis', 'av')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $result = $query->getResult();

        return $result;
    }

    
}
