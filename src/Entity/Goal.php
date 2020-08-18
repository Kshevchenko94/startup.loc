<?php

namespace App\Entity;

use App\Repository\GoalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GoalRepository::class)
 */
class Goal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=130)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $date_created;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="goals")
     */
    private $created;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deadline;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_private;
    /**
     * @var $term
     */
    private $term;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreated(): ?int
    {
        return $this->date_created;
    }

    public function setDateCreated(int $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getCreated(): ?User
    {
        return $this->created;
    }

    public function setCreated(?User $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDeadline(): ?int
    {
        return $this->deadline;
    }

    public function setDeadline(?int $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }



    public function getIsPrivate(): ?bool
    {
        return $this->is_private;
    }

    public function setIsPrivate(bool $is_private): self
    {
        $this->is_private = $is_private;

        return $this;
    }

    public function getTerm(): ?int
    {
        return ($this->deadline - time())/(24 * 60 * 60);
    }
}
