<?php

// src/Service/PostServiceInterface.php

namespace App\Service;

use Doctrine\ORM\QueryBuilder;

/**
 * Interface for PostService to define the methods for managing Post entities.
 */
interface PostServiceInterface
{
    /**
     * Retrieves a QueryBuilder for all posts, optionally filtered by category.
     *
     * @param int|null $categoryId the category ID to filter by, or null to retrieve all posts
     *
     * @return QueryBuilder the QueryBuilder for retrieving posts
     */
    public function getQueryBuilderForAllPosts(?int $categoryId = null): QueryBuilder;
}
