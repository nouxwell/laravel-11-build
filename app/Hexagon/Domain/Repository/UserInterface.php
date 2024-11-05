<?php

namespace App\Hexagon\Domain\Repository;

use App\Hexagon\Domain\DTO\Request\Auth\RegisterRequestDto;

interface UserInterface
{
    public function register(RegisterRequestDto $dto): void;
}
