<?php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController




{
    #[Route('/post/{id}', name: 'post_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
//        dd($this->getUser()->getRoles());
        $comment = new Comment();
        $comment->setPost($post);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Comment added successfully.');

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        if ($this->isGranted('role_admin')) {
            dump('Użytkownik ma rolę ROLE_ADMI');
        } else {
            dump('Użytkownik NIE ma roli ROLE_ADIN');
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'commentForm' => $form->createView(),
        ]);
    }

    #[Route('/post/add', name: 'post_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categories = $form->get('categories')->getData();
            foreach ($categories as $category) {
                $post->addCategory($category);
            }

            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'Post został utworzony pomyślnie.');

            return $this->redirectToRoute('main_page');
        }

        return $this->render('post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/post/delete/{id}", name="post_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete-post' . $post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();

            $this->addFlash('success', 'Post został usunięty pomyślnie.');
        }

        return $this->redirectToRoute('main_page');
    }

    /**
     * @Route("/post/{id}/edit", name="post_edit")
     */
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Post został zaktualizowany pomyślnie.');

            return $this->redirectToRoute('main_page');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/posts', name: 'post_list', methods: ['GET'])]
    public function list(Request $request, PostRepository $postRepository, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        $posts = $postRepository->findAll();

        $selectedCategory = $request->query->get('category');
        if ($selectedCategory) {
            $posts = $postRepository->findByCategory($selectedCategory);
        }

        return $this->render('post/list.html.twig', [
            'posts' => $posts,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}



