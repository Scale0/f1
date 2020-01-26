<?php

namespace App\Repository;

use App\Entity\Lap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Lap|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lap|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lap[]    findAll()
 * @method Lap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lap::class);
    }

    // /**
    //  * @return Lap[] Returns an array of Lap objects
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
    public function findOneBySomeField($value): ?Lap
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
