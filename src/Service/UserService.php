<?php

// src/Service/UserService.php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Service for managing User entities, including updating user information.
 */
class UserService implements UserServiceInterface
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager The entity manager used for database operations.
     * @param UserPasswordHasherInterface $passwordHasher The password hasher for encoding user passwords.
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Updates a User entity, including hashing the plain password if provided.
     *
     * @param User $user The user entity to be updated.
     *
     * @return void
     */
    public function updateUser(User $user): void
    {
        $plainPassword = $user->getPlainPassword();
        if ($plainPassword) {
            $encodedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($encodedPassword);
        }

        $this->entityManager->flush();
    }
}
