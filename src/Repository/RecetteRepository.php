<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recette[]    findAll()
 * @method Recette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

    // /**
    //  * @return Recette[] Returns an array of Recette objects
    //  */
  
    public function findLastRecipes($number)
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.createdAt', 'DESC')
            ->setMaxResults($number)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findRecipesInInterval($debutSelection, $nombreResultat)
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.createdAt', 'DESC')
            ->setFirstResult($debutSelection)
            ->setMaxResults($nombreResultat)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findRecipesWithCategory($categorie, $debutSelection, $nombreResultat)
    {
        return $this->createQueryBuilder('r')
                    ->orderBy('r.createdAt', 'DESC')
                    ->InnerJoin('r.categorie', 'c')
                    ->where('c.slug = :slug')
                    ->setParameter('slug', $categorie)
                    ->setFirstResult($debutSelection)
                    ->setMaxResults($nombreResultat)
                    ->getQuery()
                    ->getResult()
                    ;
    }

    public function CountAllRecipes()
    {
        return $this->createQueryBuilder('r')
                    ->Select('count(r) as total')
                    ->getQuery()
                    ->getOneOrNullResult()
                    ;
    }

    public function CountAllRecipesWithCategory($categorie)
    {
        return $this->createQueryBuilder('r')
                    ->Select('count(r) as total')
                    ->InnerJoin('r.categorie', 'c')
                    ->where('c.slug = :slug')
                    ->setParameter('slug', $categorie)
                    ->getQuery()
                    ->getOneOrNullResult()
                    ;
    }

    /*
    public function findOneBySomeField($value): ?Recette
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
