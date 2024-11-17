<?php

namespace App\Hexagon\Application\Services\Auth;

use App\Hexagon\Domain\DTO\Request\Auth\LoginCheckRequestDto;
use App\Hexagon\Infrastructure\Presentation\Auth\LoginCheckHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Exception;

class LoginCheckService
{
    private LoginCheckHandler $handler;

    public function __construct(LoginCheckHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws Exception
     */
    public function execute(LoginCheckRequestDto $dto): Payload
    {
        $data = $this->handler->handle($dto);
        $payloadMessage = PayloadMessage::LOGIN_SUCCESS;
        if (isset($data['qrCode']) && !empty($data['qrCode'])) {
            $payloadMessage = PayloadMessage::GENERATE_QR_CODE;
        }
        return PayloadFactory::success($payloadMessage, null, $data);
    }


}
