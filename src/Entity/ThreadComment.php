<?php

namespace App\Entity;

use App\Repository\ThreadCommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[HasLifecycleCallbacks]


#[ORM\Entity(repositoryClass: ThreadCommentRepository::class)]
class ThreadComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $byUsername = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column]
    private ?int $threadId = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTimeImmutable();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getByUsername(): ?string
    {
        return $this->byUsername;
    }

    public function setByUsername(string $byUsername): static
    {
        $this->byUsername = $byUsername;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getThreadId(): ?int
    {
        return $this->threadId;
    }

    public function setThreadId(int $threadId): static
    {
        $this->threadId = $threadId;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
