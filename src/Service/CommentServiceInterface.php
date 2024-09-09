<?php

// src/Service/CommentServiceInterface.php

namespace App\Service;

use App\Entity\Comment;

/**
 * Interface for managing Comment entities.
 */
interface CommentServiceInterface
{
    /**
     * Saves a comment.
     *
     * @param Comment $comment the comment entity to save
     */
    public function saveComment(Comment $comment): void;

    /**
     * Deletes a comment.
     *
     * @param Comment $comment the comment entity to delete
     */
    public function deleteComment(Comment $comment): void;
}
