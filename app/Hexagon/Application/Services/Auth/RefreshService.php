<?php

namespace App\Hexagon\Application\Services\Auth;

use App\Hexagon\Infrastructure\Presentation\Auth\RefreshHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Exception;

class RefreshService
{
    private RefreshHandler $handler;

    public function __construct(RefreshHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws Exception
     */
    public function execute(): Payload
    {
        $data = $this->handler->handle()->all();
        return PayloadFactory::success(PayloadMessage::REFRESH_TOKEN_SUCCESS, null, $data);
    }


}
