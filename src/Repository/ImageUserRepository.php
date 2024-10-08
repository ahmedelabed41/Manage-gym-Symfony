<?php

namespace App\Repository;

use App\Entity\ImageUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageUser>
 *
 * @method ImageUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageUser[]    findAll()
 * @method ImageUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageUser::class);
    }

//    /**
//     * @return ImageUser[] Returns an array of ImageUser objects
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

//    public function findOneBySomeField($value): ?ImageUser
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
