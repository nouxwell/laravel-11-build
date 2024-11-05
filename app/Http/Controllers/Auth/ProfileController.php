<?php

namespace App\Http\Controllers\Auth;

use App\Hexagon\Application\Services\Auth\ProfileService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    private ProfileService $service;
    public function __construct(ProfileService $service) {
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
