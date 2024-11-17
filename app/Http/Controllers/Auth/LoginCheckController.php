<?php

namespace App\Http\Controllers\Auth;

use App\Hexagon\Application\Requests\Auth\LoginCheckRequest;
use App\Hexagon\Application\Services\Auth\LoginCheckService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;

class LoginCheckController extends Controller
{
    private LoginCheckService $service;
    public function __construct(LoginCheckService $service) {
        $this->service = $service;
    }

    /**
     * @throws InvalidClassException
     * @throws \Exception
     */
    public function __invoke(LoginCheckRequest $request) {
        $dto = $request->buildDto();
        $payload = $this->service->execute($dto);
        return response()->json($payload->toArray(), $payload->getCode());
    }
}
