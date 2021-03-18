<?php

namespace App\Repository;

use App\Entity\Participant;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Particpant|null  findOneWithSite($id)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participant::class);
    }

    // Get articles with their categories if published and Paginator
    // public function findAllWithCategory(?bool $published = true, int $max = 10, int $start = 0)
    // {
    //     $queryBuilder = $this->createQueryBuilder('a')
    //                   ->join('a.category', 'c')
    //                   ->addSelect('c')
    //                   ->addOrderBy('a.publicationDate', 'DESC');

    //     if (false === $published) {
    //         $queryBuilder->andWhere('a.published!=1');
    //     } elseif (true === $published) {
    //         $queryBuilder->andWhere('a.published=1');
    //     }

    //     $query = $queryBuilder->setMaxResults($max)
    //                       ->setFirstResult($start)
    //                       ->getQuery();

    //     return new Paginator($query);
    // }

    // Same for one article by it $id
    public function findOneWithSite(int $id)
    {
        $queryBuilder = $this->createQueryBuilder('p')
                      ->join('p.site', 's')
                      ->addSelect('s')
                      ->andWhere('c.id=:id')
                      ->setParameter('id', $id);

        // if (false === $published) {
        //     $queryBuilder->andWhere('a.published!=1');
        // } elseif (true === $published) {
        //     $queryBuilder->andWhere('a.published=1');
        // }

        return $queryBuilder->getQuery()->getSingleResult();
    }

    // /**
    //  * @return Participant[] Returns an array of Participant objects
    //  */
    // public function findByExampleField($value)
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.site = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('p.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    /*
    public function findOneBySomeField($value): ?Participant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
