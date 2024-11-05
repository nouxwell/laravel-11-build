<?php

namespace App\Hexagon\Domain\Exceptions;

use App\Services\Enums\Payload\PayloadExceptionMessage;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidTokenException extends CustomException
{
    private string $localeKey = PayloadExceptionMessage::INVALID_JWT_TOKEN;
    private int $errorCode = Response::HTTP_BAD_REQUEST;
    public function __construct(Exception $previous = null) {
        parent::__construct($this->localeKey, $this->errorCode, $previous);
    }
}