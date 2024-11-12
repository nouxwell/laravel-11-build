<?php

namespace App\Hexagon\Domain\Exceptions;

use App\Services\Enums\Payload\PayloadExceptionMessage;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserAlreadyVerifiedException  extends CustomException
{
    private string $localeKey = PayloadExceptionMessage::USER_ALREADY_VERIFIED;
    private int $errorCode = Response::HTTP_NOT_FOUND;
    public function __construct(Exception $previous = null) {
        parent::__construct($this->localeKey, $this->errorCode, $previous);
    }

}
