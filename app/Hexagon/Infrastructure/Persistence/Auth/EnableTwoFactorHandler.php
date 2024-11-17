<?php

namespace App\Hexagon\Infrastructure\Persistence\Auth;

use App\Hexagon\Domain\Repository\UserInterface;

class EnableTwoFactorHandler
{
    private UserInterface $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        $this->user->enableTwoFactor();
    }
}
