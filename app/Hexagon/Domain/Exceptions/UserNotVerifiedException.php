<?php

namespace App\Hexagon\Domain\Exceptions;

use App\Services\Enums\Payload\PayloadExceptionMessage;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserNotVerifiedException  extends CustomException
{
    private string $localeKey = PayloadExceptionMessage::USER_NOT_VERIFIED;
    private int $errorCode = Response::HTTP_FORBIDDEN;
    public function __construct(Exception $previous = null) {
        parent::__construct($this->localeKey, $this->errorCode, $previous);
    }

}
