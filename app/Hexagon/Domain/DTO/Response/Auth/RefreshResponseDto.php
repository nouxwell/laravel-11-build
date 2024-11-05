<?php

namespace App\Hexagon\Domain\DTO\Response\Auth;


use App\Hexagon\Domain\DTO\BaseDto;

class RefreshResponseDto extends BaseDto
{
    public string $access_token;
    public string $token_type;
    public int $expires_in;
}
