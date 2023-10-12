<?php

namespace App\Repository;

use App\Entity\Origine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Origine>
 *
 * @method Origine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Origine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Origine[]    findAll()
 * @method Origine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrigineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Origine::class);
    }

//    /**
//     * @return Origine[] Returns an array of Origine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Origine
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
