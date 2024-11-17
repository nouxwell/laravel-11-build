<?php

namespace App\Http\Controllers\Auth;

use App\Hexagon\Application\Requests\Auth\LoginCheckRequest;
use App\Hexagon\Application\Services\Auth\GenerateLoginQrCodeService;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Http\Controllers\Controller;

class GenerateLoginQrCodeController extends Controller
{
    private GenerateLoginQrCodeService $service;
    public function __construct(GenerateLoginQrCodeService $service) {
        $this->service = $service;
    }

    /**
     * @throws InvalidClassException
     * @throws \Exception
     */
    public function __invoke(LoginCheckRequest $request) {
        $dto = $request->buildDto();
        $payload = $this->service->execute($dto);
        return response($payload->getData()['qrCode'], $payload->getCode(), ['Content-Type' => 'image/svg+xml']);

    }
}
