<?php

// src/Service/CategoryService.php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Service class for managing Category entities.
 */
class CategoryService implements CategoryServiceInterface
{
    private EntityManagerInterface $entityManager;
    private CategoryRepository $categoryRepository;

    /**
     * Constructs the CategoryService with the provided entity manager and category repository.
     *
     * @param EntityManagerInterface $entityManager The entity manager for managing entity persistence.
     * @param CategoryRepository $categoryRepository The repository for fetching Category entities.
     */
    public function __construct(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Creates a new category and persists it to the database.
     *
     * @param Category $category The category entity to create.
     */
    public function createCategory(Category $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    /**
     * Deletes a category from the database.
     *
     * @param Category $category The category entity to delete.
     */
    public function deleteCategory(Category $category): void
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }

    /**
     * Updates the category in the database.
     *
     * This method is used to save changes to existing categories.
     */
    public function updateCategory(): void
    {
        $this->entityManager->flush();
    }

    /**
     * Retrieves all categories from the database.
     *
     * @return Category[] An array of Category entities.
     */
    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }
}
