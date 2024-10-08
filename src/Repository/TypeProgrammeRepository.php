<?php

namespace App\Repository;

use App\Entity\TypeProgramme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeProgramme>
 *
 * @method TypeProgramme|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeProgramme|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeProgramme[]    findAll()
 * @method TypeProgramme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeProgrammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeProgramme::class);
    }

//    /**
//     * @return TypeProgramme[] Returns an array of TypeProgramme objects
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

//    public function findOneBySomeField($value): ?TypeProgramme
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
