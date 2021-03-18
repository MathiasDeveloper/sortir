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
            // ->addSelect('s3')
            // ->join('COUNT(t.subscriptions)', 's3')
            // ->addSelect('COUNT(t.subscriptions)')
            // ->setMaxResults(50)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllSearch($site, $like, $begindate, $enddate, bool $selforganisor, bool $selfsubscription, bool $selfunsubscription, bool $endtrips, $currentUser)
    {
        $qb = $this->createQueryBuilder('t');

        $qb = $qb->join('t.site', 's')
                ->addSelect('s')
                ->join('t.organisor', 'o')
                ->addSelect('o')
                ->join('t.subscriptions', 'sub')
                ->addSelect('sub')
        ;

        if (isset($site)) {
            $qb->andWhere('s.name=:sitename')
                ->setParameter('sitename', $site);
        }

        if (isset($like)) {
            $qb->andWhere($qb->expr()->like('t.name', ':name'))
                ->setParameter('name', '%'.$like.'%');
        }

        if (isset($begindate) && isset($enddate)) {
            $qb->andWhere('t.begin_date >= :begindate')
            ->setParameter('begindate', $begindate->format('Y-m-d 00:00:00'));
            $qb->andWhere('t.end_date <= :enddate')
            ->setParameter('enddate', $enddate->format('Y-m-d 00:00:00'));
        }
        if (isset($begindate)) {
            $qb->andWhere('t.begin_date >= :begindate')
            ->setParameter('begindate', $begindate->format('Y-m-d 00:00:00'));
        }

        if (isset($enddate)) {
            $qb->andWhere('t.end_date <= :enddate')
            ->setParameter('enddate', $enddate->format('Y-m-d 00:00:00'));
        }

        if ($selforganisor) {
            $qb->andWhere('t.organisor=:currentUser')
                ->setParameter('currentUser', $currentUser);
        }
        if ($selfsubscription) {
            dump($selfsubscription);
            $qb->andWhere('sub.id = :idSub')
                ->setParameter('idSub', $currentUser->getId());
        }
        if ($selfunsubscription) {
            $qb->andWhere('sub.id NOT IN (:idSub)')
                ->setParameter('idSub', $currentUser->getId());
        }
        if ($endtrips) {
            $qb->andWhere('t.state = :end')
                ->setParameter('end', 'ENDED');
        }

        $query = $qb->getQuery()
            ->getResult();

        return $query;
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
