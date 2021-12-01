<?php

namespace App\Repository;

use App\Entity\ListOf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListOf|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListOf|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListOf[]    findAll()
 * @method ListOf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListOfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListOf::class);
    }

    // /**
    //  * @return ListOf[] Returns an array of ListOf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListOf
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
