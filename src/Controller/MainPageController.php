<?php
// src/Controller/MainPageController.php
// src/Controller/MainPageController.php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();

        return $this->render('main_page.html.twig', [
            'posts' => $posts,
        ]);
    }
}
