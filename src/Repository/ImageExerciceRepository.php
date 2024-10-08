<?php

namespace App\Repository;

use App\Entity\ImageExercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageExercice>
 *
 * @method ImageExercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageExercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageExercice[]    findAll()
 * @method ImageExercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageExercice::class);
    }

//    /**
//     * @return ImageExercice[] Returns an array of ImageExercice objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImageExercice
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
