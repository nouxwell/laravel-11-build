<?php

namespace App\Http\Controllers\Auth;

use App\Hexagon\Application\Services\Auth\LogoutService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    private LogoutService $service;
    public function __construct(LogoutService $service) {
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
