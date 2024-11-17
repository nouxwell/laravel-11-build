<?php

namespace App\Http\Controllers\Auth;

use App\Hexagon\Application\Services\Auth\EnableTwoFactorService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;

class EnableTwoFactorController extends Controller
{
    private EnableTwoFactorService $service;
    public function __construct(EnableTwoFactorService $service) {
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
