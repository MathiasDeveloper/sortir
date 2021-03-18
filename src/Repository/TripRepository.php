<?php

namespace App\Repository;

use App\Entity\Trip;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class TripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trip::class);
    }

    public function findAllWithRelations()
    {
        return $this->createQueryBuilder('t')
            ->addSelect('o')
            ->join('t.organisor', 'o')
            ->addSelect('s')
            ->join('t.site', 's')
            ->addSelect('p')
            ->join('t.place', 'p')
            ->addSelect('s2')
            ->join('t.subscriptions', 's2')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
     * @return Trip[] Returns an array of Trip objects
     */
    public function findAllWithOrganisor(?bool $published = true, int $max = 10, int $start = 0)
    {
        $queryBuilder = $this->createQueryBuilder('t')
                      ->join('t.organisor', 'o')
                      ->addSelect('o')
                      ->addOrderBy('t.begin_date', 'DESC');

        $query = $queryBuilder->getMaxResults();

        // if (false === $published) {
        //     $queryBuilder->andWhere('a.published!=1');
        // } elseif (true === $published) {
        //     $queryBuilder->andWhere('a.published=1');
        // }

        // $query = $queryBuilder->setMaxResults($max)
        //                   ->setFirstResult($start)
        //                   ->getQuery();

        // return new Paginator($query);

        return $query;
    }

    public function findOneWithCategory(int $id, ?bool $published = true)
    {
        $queryBuilder = $this->createQueryBuilder('a')
                      ->join('a.category', 'c')
                      ->addSelect('c')
                      ->andWhere('a.id=:id')
                      ->setParameter('id', $id);

        if (false === $published) {
            $queryBuilder->andWhere('a.published!=1');
        } elseif (true === $published) {
            $queryBuilder->andWhere('a.published=1');
        }

        return $queryBuilder->getQuery()->getSingleResult();
    }

    // /**
    //  * @return Trip[] Returns an array of Trip objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trip
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
