<?php

namespace App\Repository;

use App\Entity\DriverConstructorSeason;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DriverConstructorSeason|null find($id, $lockMode = null, $lockVersion = null)
 * @method DriverConstructorSeason|null findOneBy(array $criteria, array $orderBy = null)
 * @method DriverConstructorSeason[]    findAll()
 * @method DriverConstructorSeason[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DriverConstructorSeasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DriverConstructorSeason::class);
    }

    // /**
    //  * @return DriverConstructorSeason[] Returns an array of DriverConstructorSeason objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DriverConstructorSeason
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
