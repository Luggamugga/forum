<?php

namespace App\Repository;

use App\Entity\ThreadComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ThreadComment>
 *
 * @method ThreadComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThreadComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThreadComment[]    findAll()
 * @method ThreadComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThreadCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThreadComment::class);
    }

    //    /**
    //     * @return ThreadComment[] Returns an array of ThreadComment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ThreadComment
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
