<?php

// src/Service/PostService.php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class PostService implements PostServiceInterface
{
    private PostRepository $postRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(PostRepository $postRepository, EntityManagerInterface $entityManager)
    {
        $this->postRepository = $postRepository;
        $this->entityManager = $entityManager;
    }

    public function savePost(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function deletePost(Post $post): void
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }

    public function updatePost(Post $post): void
    {
        $this->entityManager->flush();
    }

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
