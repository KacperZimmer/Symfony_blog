<?php

// src/Service/CommentService.php

namespace App\Service;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

class CommentService implements CommentServiceInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function deleteComment(Comment $comment): void
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
    }

    public function saveComment(Comment $comment): void
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}
