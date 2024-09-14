<?php

// src/Controller/PostController.php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Service\CommentServiceInterface;
use App\Service\PostServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for managing blog posts.
 */
class PostController extends AbstractController
{
    private PostServiceInterface $postService;
    private CommentServiceInterface $commentService;
    private CategoryRepository $categoryRepository;

    /**
     * PostController constructor.
     *
     * @param PostServiceInterface    $postService        The post service for handling post operations
     * @param CommentServiceInterface $commentService     The comment service for handling comment operations
     * @param CategoryRepository      $categoryRepository The repository for fetching categories
     */
    public function __construct(PostServiceInterface $postService, CommentServiceInterface $commentService, CategoryRepository $categoryRepository)
    {
        $this->postService = $postService;
        $this->commentService = $commentService;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Displays a single post with its comments and handles comment submission.
     *
     * @Route("/post/{id}", name="post_show", methods={"GET", "POST"})
     *
     * @param Request $request The HTTP request object
     * @param Post    $post    The post entity to display
     *
     * @return Response The rendered view of the post
     */
    public function show(Request $request, Post $post): Response
    {
        $comment = new Comment();
        $comment->setPost($post);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->saveComment($comment);

            $this->addFlash('success', 'Comment added successfully.');

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'commentForm' => $form->createView(),
        ]);
    }

    /**
     * Adds a new post.
     *
     * @Route("/post/add", name="post_add", methods={"GET", "POST"})
     *
     * @param Request $request The HTTP request object
     *
     * @return Response The rendered form or redirect to the main page
     */
    public function add(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categories = $form->get('categories')->getData();
            foreach ($categories as $category) {
                $post->addCategory($category);
            }

            $this->postService->savePost($post);

            $this->addFlash('success', 'Post został utworzony pomyślnie.');

            return $this->redirectToRoute('main_page');
        }

        return $this->render('post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a post.
     *
     * @Route("/post/delete/{id}", name="post_delete", methods={"POST"})
     *
     * @param Request $request The HTTP request object
     * @param Post    $post    The post entity to delete
     *
     * @return Response A redirect to the main page
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete-post'.$post->getId(), $request->request->get('_token'))) {
            $this->postService->deletePost($post);

            $this->addFlash('success', 'Post został usunięty pomyślnie.');
        }

        return $this->redirectToRoute('main_page');
    }

    /**
     * Edits an existing post.
     *
     * @Route("/post/{id}/edit", name="post_edit")
     *
     * @param Request $request The HTTP request object
     * @param Post    $post    The post entity to edit
     *
     * @return Response The rendered form or redirect to the main page
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post, [
            'method' => 'PUT',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postService->updatePost($post);

            $this->addFlash('success', 'Post został zaktualizowany pomyślnie.');

            return $this->redirectToRoute('main_page');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Lists all posts with optional category filtering and pagination.
     *
     * @Route("/posts", name="post_list", methods={"GET"})
     *
     * @param Request            $request   The HTTP request object
     * @param PaginatorInterface $paginator The paginator for handling pagination
     *
     * @return Response The rendered list of posts
     */
    public function list(Request $request, PaginatorInterface $paginator): Response
    {
        $categories = $this->categoryRepository->findAll();

        $selectedCategory = $request->query->get('category');
        $query = $this->postService->getAllPosts($selectedCategory);

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            PostRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('post/list.html.twig', [
            'pagination' => $pagination,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}
