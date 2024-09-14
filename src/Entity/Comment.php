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

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a comment on a blog post.
 *
 * @ORM\Entity
 */
#[ORM\Entity]
class Comment
{
    /**
     * The unique identifier for the comment.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * The email address of the commenter.
     */
    #[ORM\Column(type: 'string', length: 180)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    /**
     * The nickname of the commenter.
     */
    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private ?string $nick = null;

    /**
     * The content of the comment.
     */
    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    private ?string $content = null;

    /**
     * The post associated with the comment.
     */
    #[ORM\ManyToOne(targetEntity: Post::class, fetch: 'EXTRA_LAZY', inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    /**
     * Get the unique identifier for the comment.
     *
     * @return int|null The comment ID or null if not set
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the email address of the commenter.
     *
     * @return string|null The email address or null if not set
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the email address of the commenter.
     *
     * @param string $email The email address to set
     *
     * @return static Returns the current instance for method chaining
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the nickname of the commenter.
     *
     * @return string|null The nickname or null if not set
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * Set the nickname of the commenter.
     *
     * @param string $nick The nickname to set
     *
     * @return static Returns the current instance for method chaining
     */
    public function setNick(string $nick): static
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Get the content of the comment.
     *
     * @return string|null The content of the comment or null if not set
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the content of the comment.
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
     * Get the post associated with the comment.
     *
     * @return Post|null The associated post or null if not set
     */
    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     * Set the post associated with the comment.
     *
     * @param Post|null $post The post to associate with the comment
     *
     * @return static Returns the current instance for method chaining
     */
    public function setPost(?Post $post): static
    {
        $this->post = $post;

        return $this;
    }
}
