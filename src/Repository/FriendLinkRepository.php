<?php

namespace App\Repository;

use App\Entity\FriendLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FriendLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method FriendLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method FriendLink[]    findAll()
 * @method FriendLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FriendLink::class);
    }

    // /**
    //  * @return FriendLink[] Returns an array of FriendLink objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FriendLink
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
