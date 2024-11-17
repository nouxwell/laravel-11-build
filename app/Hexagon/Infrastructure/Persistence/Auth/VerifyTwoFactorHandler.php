<?php

namespace App\Hexagon\Infrastructure\Persistence\Auth;

use App\Hexagon\Domain\DTO\Request\Auth\LoginRequestDto;
use App\Hexagon\Domain\Repository\UserInterface;

class VerifyTwoFactorHandler
{
    private UserInterface $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function handle(LoginRequestDto $dto): void
    {
        $this->user->verifyTwoFactor($dto);
    }
}
