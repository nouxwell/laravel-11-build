<?php

namespace App\Hexagon\Domain\Exceptions;

use App\Services\Enums\Payload\PayloadExceptionMessage;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidClassException extends CustomException
{
    protected ?string $value = null;
    private string $localeKey = PayloadExceptionMessage::INVALID_CLASS;
    private int $errorCode = Response::HTTP_BAD_REQUEST;
    public function __construct(string $value, Exception $previous = null) {
        parent::__construct($this->localeKey, $this->errorCode, $previous);
        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

}
