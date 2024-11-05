<?php

namespace App\Hexagon\Domain\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected ?string $value = null;

    protected ?string $errorMessage = null;
    public function __construct(string $localeKey, int $code = 0, Exception $previous = null)
    {
        parent::__construct($localeKey, $code, $previous);
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}
