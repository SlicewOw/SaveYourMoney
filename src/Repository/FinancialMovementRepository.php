<?php

namespace App\Repository;

use App\Entity\FinancialMovement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FinancialMovement|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinancialMovement|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinancialMovement[]    findAll()
 * @method FinancialMovement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinancialMovementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinancialMovement::class);
    }

    // /**
    //  * @return FinancialMovement[] Returns an array of FinancialMovement objects
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
    public function findOneBySomeField($value): ?FinancialMovement
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
