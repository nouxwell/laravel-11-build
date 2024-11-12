<?php

namespace App\Services\Utils\Payload;

use App\Services\Enums\Notification\NotificationCategory;
use App\Services\Enums\Notification\NotificationType;

class NotificationPayload
{
    private int|string $id;
    private string $title;
    private string $content;
    private NotificationCategory $category;
    private NotificationType $type;
    private ?string $fileLink = null;
    private ?string $externalLink = null;
    private ?string $internalLink = null;
    private \DateTime $createdAt;
    private ?\DateTime $readAt = null;

    private int|string $userId;

    public function getId(): int|string
    {
        return $this->id;
    }

    public function setId(int|string $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getReadAt(): \DateTime | null
    {
        return $this->readAt;
    }



    public function setReadAt(\DateTime|null $readAt): static
    {
        $this->readAt = $readAt;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getCategory(): NotificationCategory
    {
        return $this->category;
    }

    public function setCategory(NotificationCategory $category): static
    {
        $this->category = $category;
        return $this;
    }


    public function getFileLink(): ?string
    {
        return $this->fileLink;
    }

    public function setFileLink(?string $fileLink): static
    {
        $this->fileLink = $fileLink;
        return $this;
    }

    public function getExternalLink(): ?string
    {
        return $this->externalLink;
    }

    public function setExternalLink(?string $externalLink): static
    {
        $this->externalLink = $externalLink;
        return $this;
    }

    public function getInternalLink(): ?string
    {
        return $this->internalLink;
    }

    public function setInternalLink(?string $internalLink): static
    {
        $this->internalLink = $internalLink;
        return $this;
    }



    public function getUserId(): int|string
    {
        return $this->userId;
    }

    public function setUserId(int|string $userId): static
    {
        $this->userId = $userId;
        return $this;

    }

    public function getType(): NotificationType
    {
        return $this->type;
    }

    public function setType(NotificationType $type): static
    {
        $this->type = $type;
        return $this;

    }


    public function toArray(): array {
        return [
            "id" => $this->getId(),
            "title" => $this->getTitle(),
            "content" => $this->getContent(),
            "type" => $this->getType(),
            "category" => $this->getCategory(),
            "fileLink" => $this->getFileLink(),
            "externalLink" => $this->getExternalLink(),
            "internalLink" => $this->getInternalLink(),
            "userId" => $this->getUserId(),
            "createdAt" => $this->getCreatedAt()->format('d-m-Y-H-i-s'), //TODO::Burası sonra db den gelen formata göre ayarlanacak
            "readAt" => $this->getReadAt()?->format('d-m-Y-H-i-s'), //TODO::Burası sonra db den gelen formata göre ayarlanacak
        ];
    }
}
