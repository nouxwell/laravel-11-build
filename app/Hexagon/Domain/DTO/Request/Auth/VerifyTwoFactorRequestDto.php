<?php

namespace App\Hexagon\Domain\DTO\Request\Auth;


use App\Hexagon\Domain\DTO\BaseDto;

class VerifyTwoFactorRequestDto extends BaseDto
{
    public string $verificationCode;
}
