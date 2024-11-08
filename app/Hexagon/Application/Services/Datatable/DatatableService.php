<?php

namespace App\Hexagon\Application\Services\Datatable;

use App\Hexagon\Domain\DTO\Request\Datatable\DatatableRequestDto;
use App\Hexagon\Infrastructure\Presentation\Datatable\DatatableHandler;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Exception;

class DatatableService
{
    private DatatableHandler $handler;

    public function __construct(DatatableHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws Exception
     */
    public function execute(DatatableRequestDto $dto): Payload
    {
        $data = $this->handler->handle($dto);
        return PayloadFactory::success(PayloadMessage::DATA_LISTED_FOR_DATATABLE, null, $data);
    }


}
