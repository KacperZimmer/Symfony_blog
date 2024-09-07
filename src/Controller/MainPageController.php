<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MainPageController extends AbstractController
{
    private $entityManager;
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/", name="main_page")
     */
    public function index(
        Request $request,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        PaginatorInterface $paginator
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

        $queryBuilder = $postRepository->queryAll();

        if ($categoryId) {
            $queryBuilder
                ->leftJoin('p.categories', 'c')
                ->andWhere('c.id = :categoryId')
                ->setParameter('categoryId', $categoryId);
        }

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



    /**
     * @Route("/admin/user/edit", name="admin_user_edit")
     */
    public function editUser(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Access denied.');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $user->getPlainPassword();
            if ($plainPassword) {
                $encodedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($encodedPassword);
            }

            $this->entityManager->flush();

            $this->addFlash('success', 'Dane użytkownika zostały zaktualizowane.');

            return $this->redirectToRoute('main_page');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
