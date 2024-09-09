<?php

// src/Controller/MainPageController.php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Service\PostServiceInterface;
use App\Service\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserServiceInterface $userService;
    private PostServiceInterface $postService;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserServiceInterface $userService,
        PostServiceInterface $postService,
    ) {
        $this->entityManager = $entityManager;
        $this->userService = $userService;
        $this->postService = $postService;
    }

    #[Route('/', name: 'main_page')]
    public function index(
        Request $request,
        CategoryRepository $categoryRepository,
        PaginatorInterface $paginator,
    ): Response {
        $categories = $categoryRepository->findAll();
        $categoryChoices = [];

        foreach ($categories as $category) {
            $categoryChoices[$category->getName()] = $category->getId();
        }

        $form = $this->createFormBuilder()
            ->add('category', ChoiceType::class, [
                'choices' => $categoryChoices,
                'choice_label' => function ($choice, $key, $value) {
                    return $key;
                },
                'required' => false,
                'placeholder' => 'Wybierz kategorię',
            ])
            ->add('search', SubmitType::class, ['label' => 'Szukaj'])
            ->getForm();

        $form->handleRequest($request);
        $categoryId = $form->get('category')->getData();

        $queryBuilder = $this->postService->getQueryBuilderForAllPosts($categoryId);

        $query = $queryBuilder->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            PostRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('main_page.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/user/edit', name: 'admin_user_edit')]
    public function editUser(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Access denied.');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->updateUser($user);

            $this->addFlash('success', 'Dane użytkownika zostały zaktualizowane.');

            return $this->redirectToRoute('main_page');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
