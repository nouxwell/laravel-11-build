<?php

namespace App\Hexagon\Infrastructure\Persistence\Auth;

use App\Hexagon\Domain\Repository\UserInterface;

class VerifyHandler
{
    private UserInterface $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function handle(int|string $id): array
    {
        return $this->user->verify($id);
    }
}
