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

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for handling Post entities.
 *
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    /**
     * Number of items per page for pagination.
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructs the repository with the manager registry and Post entity class.
     *
     * @param ManagerRegistry $registry the manager registry for the entity manager
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Creates a query builder for fetching all posts.
     *
     * @return QueryBuilder the query builder for fetching all posts
     */
    public function queryAll(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC');
    }

    /**
     * Finds posts by category ID.
     *
     * @param int $categoryId the ID of the category to filter by
     *
     * @return Post[] returns an array of Post objects
     */
    public function findByCategory(int $categoryId): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.categories', 'c')
            ->where('c.id = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->orderBy('p.id', 'DESC') // Corrected line: using 'p' instead of 'post'
            ->getQuery()
            ->getResult();
    }
}
