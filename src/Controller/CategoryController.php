<?php

// src/Controller/CategoryController.php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Controller for managing categories.
 */
class CategoryController extends AbstractController
{
    private CategoryServiceInterface $categoryService;

    /**
     * CategoryController constructor.
     *
     * @param CategoryServiceInterface $categoryService The service for handling category operations
     * @param TranslatorInterface      $translator      The translator service for handling translations
     */
    public function __construct(CategoryServiceInterface $categoryService, private readonly TranslatorInterface $translator)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Displays and handles the form for creating a new category.
     *
     * @Route("/category/news", name="category_new", methods={"GET", "POST"})
     *
     * @param Request $request The HTTP request object
     *
     * @return Response The rendered form or redirect to the category list
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->createCategory($category);

            $this->addFlash('success', $this->translator->trans('category.created.flash'));

            return $this->redirectToRoute('category_list');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Lists all categories.
     *
     * @Route("/categories", name="category_list")
     * @Route("/categories", name="category_list")
     *
     * @return Response The rendered list of categories
     */
    public function list(): Response
    {
        $categories = $this->categoryService->getAllCategories();

        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Deletes a category.
     *
     * @Route("/category/{id}/delete", name="category_delete", methods={"DELETE"})
     *
     * @param Request  $request  The HTTP request object
     * @param Category $category The category entity to delete
     *
     * @return Response A redirect to the category list
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete-category'.$category->getId(), $request->request->get('_token'))) {
            $this->categoryService->deleteCategory($category);
            $this->addFlash('success', $this->translator->trans('category.deleted.flash'));
        }

        return $this->redirectToRoute('category_list');
    }

    /**
     * Displays and handles the form for editing a category.
     *
     * @Route("/category/{id}/edit", name="category_edit", methods={"GET", "PUT"})
     *
     * @param Request  $request  The HTTP request object
     * @param Category $category The category entity to edit
     *
     * @return Response The rendered form or redirect to the category list
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category, [
            'method' => 'PUT',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->updateCategory($category);

            $this->addFlash('success', $this->translator->trans('category.updated.flash'));

            return $this->redirectToRoute('category_list');
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
