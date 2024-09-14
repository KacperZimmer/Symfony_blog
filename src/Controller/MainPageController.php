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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for handling the main page and user-related actions.
 */
class MainPageController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserServiceInterface $userService;
    private PostServiceInterface $postService;

    /**
     * MainPageController constructor.
     *
     * @param EntityManagerInterface $entityManager The entity manager for database interactions
     * @param UserServiceInterface   $userService   The user service for user-related operations
     * @param PostServiceInterface   $postService   The post service for post-related operations
     */
    public function __construct(EntityManagerInterface $entityManager, UserServiceInterface $userService, PostServiceInterface $postService)
    {
        $this->entityManager = $entityManager;
        $this->userService = $userService;
        $this->postService = $postService;
    }

    /**
     * Displays the main page with a list of posts and a category filter form.
     *
     * @Route("/", name="main_page")
     *
     * @param Request            $request            The HTTP request object
     * @param CategoryRepository $categoryRepository The repository for fetching categories
     * @param PaginatorInterface $paginator          The paginator for handling pagination
     *
     * @return Response The rendered main page with the list of posts
     */
    public function index(Request $request, CategoryRepository $categoryRepository, PaginatorInterface $paginator): Response
    {
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
                'placeholder' => 'category_placeholder',
            ])
            ->add('search', SubmitType::class, ['label' => 'search_button'])
            ->getForm();

        $form->handleRequest($request);
        $categoryId = $form->get('category')->getData();

        $queryBuilder = $this->postService->getQueryBuilderForAllPosts($categoryId);

        $query = $queryBuilder->getQuery();

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), PostRepository::PAGINATOR_ITEMS_PER_PAGE);

        return $this->render('main_page.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edits the current user's profile.
     *
     * @Route("/admin/user/edit", name="admin_user_edit")
     *
     * @param Request $request The HTTP request object
     *
     * @return Response The rendered form for editing the user or redirect to the main page
     */
    public function editUser(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Access denied.');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('plainPassword')->getData()) {
                $hashedPassword = $passwordHasher->hashPassword($user, $form->get('plainPassword')->getData());
                $user->setPassword($hashedPassword);


                $user->eraseCredentials();
            }

            $this->userService->updateUser($user);


            return $this->redirectToRoute('main_page');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
