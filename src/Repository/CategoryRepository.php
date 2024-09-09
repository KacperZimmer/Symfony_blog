<?php

/**
 * This file is part of the [Blog app] project.
 *
 * (c) [2024] [Kacper Zimmer]
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 *
 * For more information, please view the LICENSE file that was
 * distributed with this source code.
 */

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
     * @param ManagerRegistry $registry the manager registry for the entity manager
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
