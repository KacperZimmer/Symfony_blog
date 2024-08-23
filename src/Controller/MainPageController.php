<?php
// src/Controller/MainPageController.php
// src/Controller/MainPageController.php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MainPageController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="main_page")
     */
    public function index(Request $request, PostRepository $taskRepository, PaginatorInterface $paginator): Response
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();
        $pagination = $paginator->paginate(
            $taskRepository->queryAll(),
            $request->query->getInt('page', 1),
            PostRepository::PAGINATOR_ITEMS_PER_PAGE
        );
        return $this->render('main_page.html.twig', ['pagination' => $pagination]);
    }
}
