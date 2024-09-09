<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    /**
     * The unique identifier for the category.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * The name of the category.
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private ?string $name = null;

    /**
     * Get the unique identifier for the category.
     *
     * @return int|null The unique identifier or null if not set.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the name of the category.
     *
     * @return string|null The name of the category or null if not set.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the name of the category.
     *
     * @param string|null $name The name to set for the category.
     * @return static Returns the current instance for method chaining.
     */
    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
