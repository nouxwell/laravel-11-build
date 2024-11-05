<?php

namespace App\Hexagon\Application\Services\Auth;

use App\Hexagon\Infrastructure\Presentation\Auth\ProfileHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Exception;

class ProfileService
{
    private ProfileHandler $handler;

    public function __construct(ProfileHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws Exception
     */
    public function execute(): Payload
    {
        $data = $this->handler->handle()->all();
        return PayloadFactory::success(PayloadMessage::PROFILE_FETCHED_SUCCESS, null, $data);
    }


}
