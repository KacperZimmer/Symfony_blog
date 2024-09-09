<?php

// src/Service/PostServiceInterface.php

namespace App\Service;

use Doctrine\ORM\QueryBuilder;

interface PostServiceInterface
{
    public function getQueryBuilderForAllPosts(?int $categoryId = null): QueryBuilder;
}
