<?php

namespace App\Http\Controllers\Auth;

use App\Hexagon\Application\Requests\Auth\LoginRequest;
use App\Hexagon\Application\Services\Auth\LoginService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    private LoginService $service;
    public function __construct(LoginService $service) {
        $this->service = $service;
    }

    /**
     * @throws InvalidClassException
     * @throws \Exception
     */
    public function __invoke(LoginRequest $request) {
        $dto = $request->buildDto();
        $payload = $this->service->execute($dto);
        return response()->json($payload->toArray(), $payload->getCode());
    }
}
