<?php
// src/Controller/PostController.php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Service\PostServiceInterface;
use App\Service\CommentServiceInterface;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    private PostServiceInterface $postService;
    private CommentServiceInterface $commentService;
    private CategoryRepository $categoryRepository;

    public function __construct(
        PostServiceInterface $postService,
        CommentServiceInterface $commentService,
        CategoryRepository $categoryRepository
    ) {
        $this->postService = $postService;
        $this->commentService = $commentService;
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/post/{id}', name: 'post_show', methods: ['GET', 'POST'])]
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

    #[Route('/post/add', name: 'post_add', methods: ['GET', 'POST'])]
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

    #[Route('/post/delete/{id}', name: 'post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete-post' . $post->getId(), $request->request->get('_token'))) {
            $this->postService->deletePost($post);

            $this->addFlash('success', 'Post został usunięty pomyślnie.');
        }

        return $this->redirectToRoute('main_page');
    }

    #[Route("/post/{id}/edit", name:"post_edit")]
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);

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

    #[Route('/posts', name: 'post_list', methods: ['GET'])]
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

