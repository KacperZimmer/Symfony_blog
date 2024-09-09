<?php

// src/Service/PostService.php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Service class for managing Post entities.
 */
class PostService implements PostServiceInterface
{
    private PostRepository $postRepository;
    private EntityManagerInterface $entityManager;

    /**
     * Constructs the PostService with the provided repository and entity manager.
     *
     * @param PostRepository $postRepository The repository for Post entities.
     * @param EntityManagerInterface $entityManager The entity manager for managing entity persistence.
     */
    public function __construct(PostRepository $postRepository, EntityManagerInterface $entityManager)
    {
        $this->postRepository = $postRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Saves a post to the database.
     *
     * @param Post $post The post entity to save.
     */
    public function savePost(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    /**
     * Deletes a post from the database.
     *
     * @param Post $post The post entity to delete.
     */
    public function deletePost(Post $post): void
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }

    /**
     * Updates a post in the database.
     *
     * @param Post $post The post entity to update.
     */
    public function updatePost(Post $post): void
    {
        $this->entityManager->flush();
    }

    /**
     * Retrieves all posts, optionally filtered by category.
     *
     * @param int|null $categoryId The category ID to filter by, or null to retrieve all posts.
     *
     * @return Query The query for retrieving posts.
     */
    public function getAllPosts(?int $categoryId = null): Query
    {
        $queryBuilder = $this->postRepository->queryAll();

        if ($categoryId) {
            $queryBuilder
                ->leftJoin('p.categories', 'c')
                ->andWhere('c.id = :categoryId')
                ->setParameter('categoryId', $categoryId);
        }

        return $queryBuilder->getQuery();
    }

    /**
     * Retrieves a QueryBuilder for all posts, optionally filtered by category.
     *
     * @param int|null $categoryId The category ID to filter by, or null to retrieve all posts.
     *
     * @return QueryBuilder The QueryBuilder for retrieving posts.
     */
    public function getQueryBuilderForAllPosts(?int $categoryId = null): QueryBuilder
    {
        $queryBuilder = $this->postRepository->queryAll();

        if ($categoryId) {
            $queryBuilder
                ->leftJoin('p.categories', 'c')
                ->andWhere('c.id = :categoryId')
                ->setParameter('categoryId', $categoryId);
        }

        return $queryBuilder;
    }
}
