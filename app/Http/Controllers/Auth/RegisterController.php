<?php

namespace App\Http\Controllers\Auth;

use App\Hexagon\Application\Requests\Auth\RegisterRequest;
use App\Hexagon\Application\Services\Auth\RegisterService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    private RegisterService $service;
    public function __construct(RegisterService $service) {
        $this->service = $service;
    }

    /**
     * @throws InvalidClassException
     * @throws \Exception
     */
    public function __invoke(RegisterRequest $request) {
        $dto = $request->buildDto();
        $payload = $this->service->execute($dto);
        return response()->json($payload->toArray(), $payload->getCode());
    }
}
