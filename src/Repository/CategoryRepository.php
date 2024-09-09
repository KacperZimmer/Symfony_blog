<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for handling Category entities.
 *
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    /**
     * Constructs the repository with the manager registry and Category entity class.
     *
     * @param ManagerRegistry $registry The manager registry for the entity manager.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    // Uncomment and implement these methods if needed.

    // /**
    //  * Finds categories by example field.
    //  *
    //  * @param mixed $value The value to search for.
    //  * @return Category[] Returns an array of Category objects.
    //  */
    // public function findByExampleField($value): array
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('c.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    // /**
    //  * Finds a single category by some field.
    //  *
    //  * @param mixed $value The value to search for.
    //  * @return Category|null Returns a Category object or null if not found.
    //  */
    // public function findOneBySomeField($value): ?Category
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
}
