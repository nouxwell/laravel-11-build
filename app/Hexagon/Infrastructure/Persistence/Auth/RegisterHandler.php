<?php

namespace App\Hexagon\Infrastructure\Persistence\Auth;


use App\Hexagon\Domain\DTO\Request\Auth\RegisterRequestDto;
use App\Hexagon\Domain\Repository\UserInterface;

class RegisterHandler
{
    private UserInterface $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function handle(RegisterRequestDto $dto): void
    {
        $this->user->register($dto);
    }
}
