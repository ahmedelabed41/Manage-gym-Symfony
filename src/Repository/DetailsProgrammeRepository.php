<?php

namespace App\Repository;

use App\Entity\DetailsProgramme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetailsProgramme>
 *
 * @method DetailsProgramme|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailsProgramme|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailsProgramme[]    findAll()
 * @method DetailsProgramme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailsProgrammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailsProgramme::class);
    }

//    /**
//     * @return DetailsProgramme[] Returns an array of DetailsProgramme objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DetailsProgramme
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
