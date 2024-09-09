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

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a category in the blog.
 *
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    /**
     * The unique identifier for the category.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * The name of the category.
     */
    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private ?string $name = null;

    /**
     * The posts associated with the category.
     *
     * @var Collection<int, Post>
     */
    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'categories')]
    private Collection $posts;

    /**
     * Category constructor initializes the posts collection.
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * Get the unique identifier for the category.
     *
     * @return int|null The unique identifier or null if not set
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the name of the category.
     *
     * @return string|null The name of the category or null if not set
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the name of the category.
     *
     * @param string|null $name The name to set for the category
     *
     * @return static Returns the current instance for method chaining
     */
    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the posts associated with the category.
     *
     * @return Collection<int, Post> The posts collection
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }
}
