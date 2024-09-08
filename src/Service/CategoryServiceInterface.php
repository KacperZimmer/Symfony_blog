<?php
// src/Service/CategoryServiceInterface.php
namespace App\Service;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryRepository;

interface CategoryServiceInterface
{
    public function createCategory(Category $category): void;

    public function deleteCategory(Category $category): void;

    public function updateCategory(): void;

    /**
     * @return Category[]
     */
    public function getAllCategories(): array;
}
