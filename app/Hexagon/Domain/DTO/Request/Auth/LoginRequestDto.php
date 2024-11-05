<?php

namespace App\Hexagon\Domain\DTO\Request\Auth;


use App\Hexagon\Domain\DTO\BaseDto;

class LoginRequestDto extends BaseDto
{
    public string $email;
    public string $password;
}
