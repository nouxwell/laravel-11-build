<?php

namespace App\Hexagon\Infrastructure\Persistence\Auth;

use App\Hexagon\Domain\Repository\UserInterface;

class DisableTwoFactorHandler
{
    private UserInterface $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        $this->user->disableTwoFactor();
    }
}
