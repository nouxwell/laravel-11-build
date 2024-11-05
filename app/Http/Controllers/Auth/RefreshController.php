<?php

namespace App\Http\Controllers\Auth;

use App\Hexagon\Application\Services\Auth\RefreshService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;

class RefreshController extends Controller
{
    private RefreshService $service;
    public function __construct(RefreshService $service) {
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
