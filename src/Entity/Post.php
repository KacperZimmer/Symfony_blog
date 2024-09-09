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

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a blog post.
 *
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    /**
     * The unique identifier for the post.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * The title of the post.
     *
     * @var string|null
     */
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private ?string $title = null;

    /**
     * The content of the post.
     *
     * @var string|null
     */
    #[ORM\Column(length: 200)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 200)]
    private ?string $content = null;

    /**
     * The categories associated with the post.
     *
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'posts')]
    #[ORM\JoinTable(name: 'post_category')]
    private Collection $categories;

    /**
     * The comments associated with the post.
     *
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'post', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $comments;

    /**
     * Constructor to initialize collections.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Get the unique identifier for the post.
     *
     * @return int|null The post ID or null if not set
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the title of the post.
     *
     * @return string|null The title of the post or null if not set
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the title of the post.
     *
     * @param string $title The title to set
     *
     * @return static Returns the current instance for method chaining
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the content of the post.
     *
     * @return string|null The content of the post or null if not set
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the content of the post.
     *
     * @param string $content The content to set
     *
     * @return static Returns the current instance for method chaining
     */
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the categories associated with the post.
     *
     * @return Collection<int, Category> The categories collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * Add a category to the post.
     *
     * @param Category $category The category to add
     *
     * @return static Returns the current instance for method chaining
     */
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    /**
     * Remove a category from the post.
     *
     * @param Category $category The category to remove
     *
     * @return static Returns the current instance for method chaining
     */
    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * Get the comments associated with the post.
     *
     * @return Collection<int, Comment> The comments collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * Add a comment to the post.
     *
     * @param Comment $comment The comment to add
     *
     * @return static Returns the current instance for method chaining
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPost($this);
        }

        return $this;
    }

    /**
     * Remove a comment from the post.
     *
     * @param Comment $comment The comment to remove
     *
     * @return static Returns the current instance for method chaining
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }
}
