<?php

// src/Controller/CommentController.php

namespace App\Controller;

use App\Entity\Comment;
use App\Service\CommentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for managing comments.
 */
class CommentController extends AbstractController
{
    private CommentServiceInterface $commentService;

    /**
     * CommentController constructor.
     *
     * @param CommentServiceInterface $commentService The comment service to handle comment operations
     */
    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Deletes a comment.
     *
     * @Route("/comment/{id}/delete", name="comment_delete", methods={"POST"})
     *
     * @param Request $request The HTTP request object
     * @param Comment $comment The comment entity to delete
     *
     * @return Response A redirect response to the post page
     */
    public function delete(Request $request, Comment $comment): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete-comment'.$comment->getId(), $request->request->get('_token'))) {
            $this->commentService->deleteComment($comment);

            $this->addFlash('success', 'Komentarz został usunięty.');
        }

        return $this->redirectToRoute('post_show', ['id' => $comment->getPost()->getId()]);
    }
}
