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
     * @param User $user The user entity to be updated.
     *
     * @return void
     */
    public function updateUser(User $user): void;
}
