<?php

namespace App\Http\Controllers\Auth;

use App\Hexagon\Application\Services\Auth\DisableTwoFactorService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;

class DisableTwoFactorController extends Controller
{
    private DisableTwoFactorService $service;
    public function __construct(DisableTwoFactorService $service) {
        $this->service = $service;
    }

    /**
     * @throws InvalidClassException
     * @throws \Exception
     */
    public function __invoke() {
        $payload = $this->service->execute();
        return response()->json($payload->toArray(), $payload->getCode());
    }
}
