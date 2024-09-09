<?php

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
     * @param ManagerRegistry $registry The manager registry for the entity manager.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Creates a query builder for fetching all posts.
     *
     * @return QueryBuilder The query builder for fetching all posts.
     */
    public function queryAll(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC');
    }

    /**
     * Finds posts by category ID.
     *
     * @param int $categoryId The ID of the category to filter by.
     * @return Post[] Returns an array of Post objects.
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
