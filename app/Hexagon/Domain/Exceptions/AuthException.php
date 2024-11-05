<?php

namespace App\Hexagon\Domain\Exceptions;

use App\Services\Enums\Payload\PayloadExceptionMessage;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthException extends CustomException
{
    private string $localeKey = PayloadExceptionMessage::AUTHENTICATION_ERROR;
    private int $errorCode = Response::HTTP_UNAUTHORIZED;
    public function __construct(Exception $previous = null) {
        parent::__construct($this->localeKey, $this->errorCode, $previous);
    }
}
