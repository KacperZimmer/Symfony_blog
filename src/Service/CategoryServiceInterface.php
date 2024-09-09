<?php

// src/Service/CategoryServiceInterface.php

namespace App\Service;

use App\Entity\Category;

/**
 * Interface for the Category service.
 */
interface CategoryServiceInterface
{
    /**
     * Creates a new category.
     *
     * @param Category $category the category entity to create
     */
    public function createCategory(Category $category): void;

    /**
     * Deletes an existing category.
     *
     * @param Category $category the category entity to delete
     */
    public function deleteCategory(Category $category): void;

    /**
     * Updates an existing category.
     *
     * This method is used to save changes to an existing category.
     */
    public function updateCategory(): void;

    /**
     * Retrieves all categories.
     *
     * @return Category[] an array of Category entities
     */
    public function getAllCategories(): array;
}
