<?php

// src/Service/UserServiceInterface.php
namespace App\Service;

use App\Entity\User;

interface UserServiceInterface
{
    public function updateUser(User $user): void;
}
