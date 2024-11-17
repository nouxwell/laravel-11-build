<?php

namespace App\Http\Controllers\Auth;

use App\Hexagon\Application\Services\Auth\ResetTwoFactorService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;

class ResetTwoFactorController extends Controller
{
    private ResetTwoFactorService $service;
    public function __construct(ResetTwoFactorService $service) {
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
