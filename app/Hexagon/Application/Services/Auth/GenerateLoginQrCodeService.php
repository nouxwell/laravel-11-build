<?php

namespace App\Hexagon\Application\Services\Auth;

use App\Hexagon\Domain\DTO\Request\Auth\LoginCheckRequestDto;
use App\Hexagon\Infrastructure\Persistence\Auth\GenerateLoginQrCodeHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Exception;

class GenerateLoginQrCodeService
{
    private GenerateLoginQrCodeHandler $handler;

    public function __construct(GenerateLoginQrCodeHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws Exception
     */
    public function execute(LoginCheckRequestDto $dto): Payload
    {
        $qrCode = $this->handler->handle($dto);
        return PayloadFactory::success(PayloadMessage::GENERATE_QR_CODE, null, ['qrCode' => $qrCode]);
    }


}
