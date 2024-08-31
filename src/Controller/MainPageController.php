<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
    public function index(
        Request $request,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        PaginatorInterface $paginator
    ): Response {
        // Formularz wyszukiwania
        $categories = $categoryRepository->findAll();
        $categoryChoices = [];

        foreach ($categories as $category) {
            $categoryChoices[$category->getName()] = $category->getId();
        }

        $form = $this->createFormBuilder()
            ->add('category', ChoiceType::class, [
                'choices' => $categoryChoices,
                'choice_label' => function ($choice, $key, $value) {
                    return $key; // Display category name
                },
                'required' => false,
                'placeholder' => 'Wybierz kategorię',
            ])
            ->add('search', SubmitType::class, ['label' => 'Szukaj'])
            ->getForm();

        $form->handleRequest($request);
        $categoryId = $form->get('category')->getData();

        // Pobierz posty według kategorii
        $queryBuilder = $postRepository->createQueryBuilder('p');

        if ($categoryId) {
            $queryBuilder
                ->leftJoin('p.categories', 'c')
                ->andWhere('c.id = :categoryId')
                ->setParameter('categoryId', $categoryId);
        }

        $query = $queryBuilder->getQuery();

        // Paginacja
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
}
