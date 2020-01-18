<?php

namespace App\Repository;

use App\Entity\ScheduledMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ScheduledMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduledMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduledMessage[]    findAll()
 * @method ScheduledMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduledMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScheduledMessage::class);
    }

    /**
     * @return ScheduledMessage[]
     * @throws \Exception
     */
    public function findMessagesToExecute():?array
    {
        return $this->createQueryBuilder('scheduledMessage')
            ->andWhere('scheduledMessage.scheduled <= :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult()
        ;
    }

    public function add(ScheduledMessage $message) {
        $this->getEntityManager()->persist($message);
    }

    public function flush() {
        $this->getEntityManager()->flush();
    }
}
