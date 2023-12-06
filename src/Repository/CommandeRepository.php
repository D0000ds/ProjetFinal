<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

   /**
    * @return Commande[] Returns an array of Commande objects
    */
   public function semaine($id, $dateAjd, $semaine): array
   {
        $entityManager = $this->getEntityManager(); // get the EntityManager
        $queryBuilder = $entityManager->createQueryBuilder();

        $query = $queryBuilder
            ->select('c')
            ->from('App\Entity\Commande', 'c')
            ->where('c.dateCommande BETWEEN :start_date AND :end_date')
            ->andWhere('c.client = :id')
            ->orderBy('c.dateCommande', 'DESC')
            ->setParameter('start_date', $semaine)
            ->setParameter('end_date', $dateAjd)
            ->setParameter('id', $id)
            ->getQuery();

        $result = $query->getResult();

        return $result;
   }

   /**
    * @return Commande[] Returns an array of Commande objects
    */
    public function mois($id, $dateAjd, $mois): array
    {
         $entityManager = $this->getEntityManager(); // get the EntityManager
         $queryBuilder = $entityManager->createQueryBuilder();
 
         $query = $queryBuilder
             ->select('c')
             ->from('App\Entity\Commande', 'c')
             ->where('c.dateCommande BETWEEN :start_date AND :end_date')
             ->andWhere('c.client = :id')
             ->orderBy('c.dateCommande', 'DESC')
             ->setParameter('start_date', $mois)
             ->setParameter('end_date', $dateAjd)
             ->setParameter('id', $id)
             ->getQuery();
 
         $result = $query->getResult();
 
         return $result;
    }

    /**
    * @return Commande[] Returns an array of Commande objects
    */
    public function annee($id, $dateAjd, $annee): array
    {
         $entityManager = $this->getEntityManager(); // get the EntityManager
         $queryBuilder = $entityManager->createQueryBuilder();
 
         $query = $queryBuilder
             ->select('c')
             ->from('App\Entity\Commande', 'c')
             ->where('c.dateCommande BETWEEN :start_date AND :end_date')
             ->andWhere('c.client = :id')
             ->orderBy('c.dateCommande', 'DESC')
             ->setParameter('start_date', $annee)
             ->setParameter('end_date', $dateAjd)
             ->setParameter('id', $id)
             ->getQuery();
 
         $result = $query->getResult();
 
         return $result;
    }

     /**
    * @return Commande[] Returns an array of Commande objects
    */
    public function date($dateAjd, $annee): array
    {
         $entityManager = $this->getEntityManager(); // get the EntityManager
         $queryBuilder = $entityManager->createQueryBuilder();
 
         $query = $queryBuilder
             ->select('c')
             ->from('App\Entity\Commande', 'c')
             ->where('c.dateCommande BETWEEN :start_date AND :end_date')
             ->orderBy('c.dateCommande', 'DESC')
             ->setParameter('start_date', $annee)
             ->setParameter('end_date', $dateAjd)
             ->getQuery();
 
         $result = $query->getResult();
 
         return $result;
    }

}
