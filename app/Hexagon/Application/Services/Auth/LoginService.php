<?php

namespace App\Hexagon\Application\Services\Auth;

use App\Hexagon\Domain\DTO\Request\Auth\LoginRequestDto;
use App\Hexagon\Infrastructure\Presentation\Auth\LoginHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Exception;

class LoginService
{
    private LoginHandler $handler;

    public function __construct(LoginHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws Exception
     */
    public function execute(LoginRequestDto $dto): Payload
    {
        $data = $this->handler->handle($dto)->all();
        return PayloadFactory::success(PayloadMessage::LOGIN_SUCCESS, null, $data);
    }


}
