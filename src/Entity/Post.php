<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $Title = null;

    #[ORM\Column(length: 200)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'getPosts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $UserID = null;


    #[ORM\Column(type: 'json')]
    private array $tags = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getUserID(): ?User
    {
        return $this->UserID;
    }

    public function setUserID(?User $UserID): static
    {
        $this->UserID = $UserID;

        return $this;
    }
}
