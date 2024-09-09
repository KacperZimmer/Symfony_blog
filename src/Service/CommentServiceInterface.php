<?php

// src/Service/CommentServiceInterface.php

namespace App\Service;

use App\Entity\Comment;

interface CommentServiceInterface
{
    public function saveComment(Comment $comment): void;

    public function deleteComment(Comment $comment): void;
}
