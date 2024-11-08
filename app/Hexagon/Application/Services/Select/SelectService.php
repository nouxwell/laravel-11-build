<?php

namespace App\Hexagon\Application\Services\Select;

use App\Hexagon\Domain\DTO\Request\Select\SelectRequestDto;
use App\Hexagon\Infrastructure\Presentation\Select\SelectHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Exception;

class SelectService
{
    private SelectHandler $handler;

    public function __construct(SelectHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws Exception
     */
    public function execute(SelectRequestDto $dto): Payload
    {
        $data = $this->handler->handle($dto);
        return PayloadFactory::success(PayloadMessage::DATA_LISTED_FOR_SELECT, null, $data);
    }


}
