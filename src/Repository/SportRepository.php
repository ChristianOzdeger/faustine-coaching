<?php

namespace App\Repository;

use App\Entity\Sport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sport[]    findAll()
 * @method Sport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sport::class);
    }

    // /**
    //  * @return Sport[] Returns an array of Sport objects
    //  */
    
    public function findSportsWithThemes($themes, $debutSelection, $nombreResultat)
    {
        return $this->createQueryBuilder('r')
                    ->orderBy('r.createdAt', 'DESC')
                    ->InnerJoin('r.themes', 'c')
                    ->where('c.slug = :slug')
                    ->setParameter('slug', $themes)
                    ->setFirstResult($debutSelection)
                    ->setMaxResults($nombreResultat)
                    ->getQuery()
                    ->getResult()
                    ;
    }

    public function findLastSports($number)
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.createdAt', 'DESC')
            ->setMaxResults($number)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSportsInInterval($debutSelection, $nombreResultat)
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.createdAt', 'DESC')
            ->setFirstResult($debutSelection)
            ->setMaxResults($nombreResultat)
            ->getQuery()
            ->getResult()
        ;
    }

    public function countAllSports()
    {
        return $this->createQueryBuilder('r')
                    ->Select('count(r) as total')
                    ->getQuery()
                    ->getOneOrNullResult()
                    ;
    }
    
    public function countAllSportsWiththemes($theme)
    {
        return $this->createQueryBuilder('r')
                    ->Select('count(r) as total')
                    ->InnerJoin('r.themes', 'c')
                    ->where('c.slug = :slug')
                    ->setParameter('slug', $theme)
                    ->getQuery()
                    ->getOneOrNullResult()
                    ;
    }

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sport
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
