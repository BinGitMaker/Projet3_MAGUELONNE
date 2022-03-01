<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param array $categories
     * @return \Doctrine\ORM\Query
     */
    public function findByCategory(array $categories)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.category IN (:categories)')
            ->setParameter('categories', $categories)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
//            ->getResult()
        ;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function queryFindAll()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC');
    }

    /*
    public function findOneBySomeField($value): ?Article
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
