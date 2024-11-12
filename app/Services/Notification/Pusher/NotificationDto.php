<?php

namespace App\Services\Notification\Pusher;

use App\Services\Enums\Notification\NotificationCategory;
use App\Services\Enums\Notification\NotificationType;

class NotificationDto
{
    private string $locale;
    private string $email;
    private string $titleLocale;
    private ?array $titleLocaleOptions = null;
    private string $contentLocale;
    private ?array $contentLocaleOptions = null;
    private NotificationCategory $category;
    private NotificationType $type;
    private ?string $fileLink = null;
    private ?string $externalLink = null;
    private ?string $internalLink = null;

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): static
    {
        $this->locale = $locale;
        return $this;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getTitleLocale(): string
    {
        return $this->titleLocale;
    }

    public function setTitleLocale(string $titleLocale): static
    {
        $this->titleLocale = $titleLocale;
        return $this;
    }

    public function getTitleLocaleOptions(): ?array
    {
        return $this->titleLocaleOptions;
    }

    public function setTitleLocaleOptions(?array $titleLocaleOptions): static
    {
        $this->titleLocaleOptions = $titleLocaleOptions;
        return $this;
    }

    public function getContentLocale(): string
    {
        return $this->contentLocale;
    }

    public function setContentLocale(string $contentLocale): static
    {
        $this->contentLocale = $contentLocale;
        return $this;
    }

    public function getContentLocaleOptions(): ?array
    {
        return $this->contentLocaleOptions;
    }

    public function setContentLocaleOptions(?array $contentLocaleOptions): static
    {
        $this->contentLocaleOptions = $contentLocaleOptions;
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
