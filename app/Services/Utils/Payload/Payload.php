<?php

namespace App\Services\Utils\Payload;

class Payload
{
    private int $code;
    private bool $status;
    private string $message;
    private ?array $data = [];
    private ?array $errors = [];

    public function getCode(): int {
        return $this->code;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;
        return $this;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status= $status;
        return $this;

    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $localeKey): static
    {
        $this->message = $localeKey;
        return $this;
    }

    public function getData(): ?array {
        return $this->data;
    }

    public function setData(?array $data = []): static
    {
        $this->data = $data;
        return $this;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }

    public function setErrors(?array $errors = []): static
    {
        $this->errors = $errors;
        return $this;
    }

    public function toArray(): array {
        return [
            "code"=> $this->getCode(),
            "status"=> $this->getStatus(),
            "message"=>$this->getMessage(),
            "data"=>$this->getData(),
            "errors"=>$this->getErrors()
        ];
    }
}
