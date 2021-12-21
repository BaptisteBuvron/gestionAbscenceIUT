<?php

namespace App\Repository;

use App\Entity\GroupTD;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupTD|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupTD|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupTD[]    findAll()
 * @method GroupTD[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupTDRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupTD::class);
    }

    // /**
    //  * @return GroupTD[] Returns an array of GroupTD objects
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
    public function findOneBySomeField($value): ?GroupTD
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
