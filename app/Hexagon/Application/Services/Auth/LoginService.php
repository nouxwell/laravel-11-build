<?php

namespace App\Hexagon\Application\Services\Auth;

use App\Hexagon\Domain\DTO\Request\Auth\LoginRequestDto;
use App\Hexagon\Infrastructure\Persistence\Auth\VerifyTwoFactorHandler;
use App\Hexagon\Infrastructure\Presentation\Auth\LoginHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Exception;

class LoginService
{
    private LoginHandler $handler;
    private VerifyTwoFactorHandler $verifyTwoFactorHandler;

    public function __construct(LoginHandler $handler, VerifyTwoFactorHandler $verifyTwoFactorHandler)
    {
        $this->handler = $handler;
        $this->verifyTwoFactorHandler = $verifyTwoFactorHandler;
    }

    /**
     * @throws Exception
     */
    public function execute(LoginRequestDto $dto): Payload
    {
        $this->verifyTwoFactorHandler->handle($dto);
        $data = $this->handler->handle($dto);
        return PayloadFactory::success(PayloadMessage::LOGIN_SUCCESS, null, $data->all());
    }


}
