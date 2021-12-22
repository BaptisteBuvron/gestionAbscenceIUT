<?php

namespace App\Repository;

use App\Entity\AbsencesReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AbsencesReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbsencesReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbsencesReport[]    findAll()
 * @method AbsencesReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbsencesReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbsencesReport::class);
    }

    // /**
    //  * @return AbsencesReport[] Returns an array of AbsencesReport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AbsencesReport
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
