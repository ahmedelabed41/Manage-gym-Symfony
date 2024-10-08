<?php

namespace App\Repository;

use App\Entity\ImageBanniere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageBanniere>
 *
 * @method ImageBanniere|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageBanniere|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageBanniere[]    findAll()
 * @method ImageBanniere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageBanniereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageBanniere::class);
    }

//    /**
//     * @return ImageBanniere[] Returns an array of ImageBanniere objects
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

//    public function findOneBySomeField($value): ?ImageBanniere
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
