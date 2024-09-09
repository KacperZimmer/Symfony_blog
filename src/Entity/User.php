<?php

/**
 * This file is part of the [Blog app] project.
 *
 * (c) [2024] [Kacper Zimmer]
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 *
 * For more information, please view the LICENSE file that was
 * distributed with this source code.
 */

namespace App\Entity;

use App\Entity\Enum\UserRole;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a user in the application.
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="users")
 * @ORM\UniqueConstraint(name="email_idx", columns={"email"})
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\UniqueConstraint(name: 'email_idx', columns: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * The unique identifier for the user.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * The email address of the user.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    /**
     * The roles assigned to the user.
     *
     * @var array<int, string>
     */
    #[ORM\Column(type: 'json')]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'array')]
    private array $roles = [];

    /**
     * The plain password entered by the user (not persisted).
     *
     * @var string|null
     */
    private ?string $plainPassword = null;

    /**
     * The hashed password of the user.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private ?string $password = null;

    /**
     * The posts created by the user.
     *
     * @var Collection<int, Post>
     */
    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'UserID', orphanRemoval: true)]
    private Collection $getPosts;

    /**
     * Constructor to initialize collections.
     */
    public function __construct()
    {
        $this->getPosts = new ArrayCollection();
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return int|null The user ID or null if not set
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the email address of the user.
     *
     * @return string|null The email address or null if not set
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the email address of the user.
     *
     * @param string $email The email address to set
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Get the user identifier (used for authentication).
     *
     * @return string The user identifier (email)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     *
     * @return string The username (email)
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Get the roles assigned to the user.
     *
     * @return array<int, string> The roles
     *
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        foreach ($roles as $role) {
            if (!is_string($role)) {
                throw new \InvalidArgumentException('Each role must be a string');
            }
        }

        if (!in_array(UserRole::ROLE_USER->value, $roles, true)) {
            $roles[] = UserRole::ROLE_USER->value;
        }

        return array_unique($roles);
    }

    /**
     * Set the roles assigned to the user.
     *
     * @param array<int, string> $roles The roles to set
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Get the hashed password of the user.
     *
     * @return string|null The hashed password or null if not set
     *
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the hashed password of the user.
     *
     * @param string $password The hashed password to set
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Returns a salt if necessary for the password hashing algorithm.
     *
     * @return string|null Null if using a modern hashing algorithm (bcrypt or sodium)
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * Removes sensitive information from the token.
     *
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * Get the plain password (not persisted).
     *
     * @return string|null The plain password or null if not set
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * Set the plain password (not persisted).
     *
     * @param string|null $plainPassword The plain password to set, or null to unset it
     *
     * @return self Returns the current instance for method chaining
     */
    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
