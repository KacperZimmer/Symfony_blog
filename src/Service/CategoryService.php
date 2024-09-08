<?php
// src/Service/CategoryService.php
namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService implements CategoryServiceInterface
{
    private EntityManagerInterface $entityManager;
    private CategoryRepository $categoryRepository;

    public function __construct(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory(Category $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function deleteCategory(Category $category): void
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }

    public function updateCategory(): void
    {
        $this->entityManager->flush();
    }

    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }
}
