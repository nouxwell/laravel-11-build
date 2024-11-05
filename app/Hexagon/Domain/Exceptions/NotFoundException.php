<?php

namespace App\Hexagon\Domain\Exceptions;

use App\Services\Enums\Payload\PayloadExceptionMessage;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends CustomException
{
    protected ?string $value = null;
    private string $localeKey = PayloadExceptionMessage::NOT_FOUND;
    private int $errorCode = Response::HTTP_NOT_FOUND;
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
