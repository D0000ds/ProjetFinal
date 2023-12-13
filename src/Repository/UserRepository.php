<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
* @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function moyenneAvis($id){
        $entityManager = $this->getEntityManager(); // get the EntityManager
        $queryBuilder = $entityManager->createQueryBuilder();

        $query = $queryBuilder
        ->select('AVG(a.note) AS moyenneSatisfaction')
        ->from('App\Entity\Avis', 'a')
        ->where('a.client = :id')
        ->setParameter('id', $id)
        ->getQuery();

        $result = $query->getOneOrNullResult();

        return $result;
    }

    public function valideUser(){
        $entityManager = $this->getEntityManager(); // get the EntityManager
        $queryBuilder = $entityManager->createQueryBuilder();

        $query = $queryBuilder
            ->select('u')
            ->from('App\Entity\User', 'u')
            ->where($queryBuilder->expr()->neq('u.password', ':password'))
            ->setParameter('password', 'delete')
            ->getQuery();

        $result = $query->getResult();

        return $result;
    }
}
