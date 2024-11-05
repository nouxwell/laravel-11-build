<?php

namespace App\Hexagon\Domain\DTO\Response\Auth;


use App\Hexagon\Domain\DTO\BaseDto;

class ProfileResponseDto extends BaseDto
{
    public string $name;
    public string $surname;
    public string $username;
    public string $email;
}
