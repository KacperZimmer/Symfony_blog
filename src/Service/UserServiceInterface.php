<?php

// src/Service/UserServiceInterface.php

namespace App\Service;

use App\Entity\User;

/**
 * Interface for user-related services.
 */
interface UserServiceInterface
{
    /**
     * Updates a User entity, including processing any password changes.
     *
     * @param User $user the user entity to be updated
     */
    public function updateUser(User $user): void;
}
