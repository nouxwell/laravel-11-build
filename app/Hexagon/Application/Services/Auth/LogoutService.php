<?php

namespace App\Hexagon\Application\Services\Auth;

use App\Hexagon\Infrastructure\Presentation\Auth\LogoutHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Exception;

class LogoutService
{
    private LogoutHandler $handler;

    public function __construct(LogoutHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws Exception
     */
    public function execute(): Payload
    {
        $this->handler->handle();
        return PayloadFactory::success(PayloadMessage::LOGOUT_SUCCESS, null, null);
    }


}
