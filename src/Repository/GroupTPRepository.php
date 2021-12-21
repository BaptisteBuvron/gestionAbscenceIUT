<?php

namespace App\Repository;

use App\Entity\GroupTP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupTP|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupTP|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupTP[]    findAll()
 * @method GroupTP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupTPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupTP::class);
    }

    // /**
    //  * @return GroupTP[] Returns an array of GroupTP objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupTP
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
