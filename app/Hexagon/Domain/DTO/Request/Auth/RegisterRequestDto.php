<?php

namespace App\Hexagon\Domain\DTO\Request\Auth;


use App\Hexagon\Domain\DTO\BaseDto;

class RegisterRequestDto extends BaseDto
{
    public string $name;
    public string $surname;
    public string $username;
    public string $email;
    public string $password;
}
