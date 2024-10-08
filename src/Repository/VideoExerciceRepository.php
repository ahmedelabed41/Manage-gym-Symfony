<?php

namespace App\Repository;

use App\Entity\VideoExercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VideoExercice>
 *
 * @method VideoExercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoExercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoExercice[]    findAll()
 * @method VideoExercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoExercice::class);
    }

//    /**
//     * @return VideoExercice[] Returns an array of VideoExercice objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VideoExercice
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
