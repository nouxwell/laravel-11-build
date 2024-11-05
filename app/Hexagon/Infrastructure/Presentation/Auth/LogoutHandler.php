<?php

namespace App\Hexagon\Infrastructure\Presentation\Auth;


use App\Hexagon\Domain\Exceptions\InvalidClassException;

class LogoutHandler
{
    public function __construct() {}

    /**
     * @throws InvalidClassException
     */
    public function handle(): void
    {
        auth()->logout();
    }

}
