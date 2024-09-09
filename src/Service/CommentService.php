<?php

// src/Service/CommentService.php

namespace App\Service;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Service class for managing Comment entities.
 */
class CommentService implements CommentServiceInterface
{
    private EntityManagerInterface $entityManager;

    /**
     * Constructs the CommentService with the provided entity manager.
     *
     * @param EntityManagerInterface $entityManager The entity manager for managing entity persistence.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Deletes a comment from the database.
     *
     * @param Comment $comment The comment entity to delete.
     */
    public function deleteComment(Comment $comment): void
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
    }

    /**
     * Saves a comment to the database.
     *
     * @param Comment $comment The comment entity to save.
     */
    public function saveComment(Comment $comment): void
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}
