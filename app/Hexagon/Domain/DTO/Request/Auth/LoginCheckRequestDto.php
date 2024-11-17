<?php

namespace App\Hexagon\Domain\DTO\Request\Auth;


use App\Hexagon\Domain\DTO\BaseDto;

class LoginCheckRequestDto extends BaseDto
{
    public string $email;
    public string $password;
}
