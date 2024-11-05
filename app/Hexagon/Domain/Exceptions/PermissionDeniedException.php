<?php

namespace App\Hexagon\Domain\Exceptions;

use App\Services\Enums\Payload\PayloadExceptionMessage;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class PermissionDeniedException extends CustomException
{
    private string $localeKey = PayloadExceptionMessage::PERMISSION_DENIED;
    private int $errorCode = Response::HTTP_FORBIDDEN;
    public function __construct(Exception $previous = null) {
        parent::__construct($this->localeKey, $this->errorCode, $previous);
    }
}
