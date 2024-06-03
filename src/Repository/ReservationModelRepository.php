<?php

namespace App\Repository;

use App\Entity\ReservationModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReservationModel>
 *
 * @method ReservationModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationModel[]    findAll()
 * @method ReservationModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationModel::class);
    }

    //    /**
    //     * @return ReservationModel[] Returns an array of ReservationModel objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ReservationModel
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
