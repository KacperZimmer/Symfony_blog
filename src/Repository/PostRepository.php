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
            ->select('p.id, p.title, p.content')
            ->orderBy('p.id', 'DESC');
    }
}
