<?php

namespace App\Hexagon\Application\Services\Datatable;

use App\Hexagon\Application\Jobs\DatatableExportJob;
use App\Hexagon\Domain\DTO\Request\Datatable\DatatableRequestDto;
use App\Services\Enums\Payload\PayloadMessage;
use App\Services\Utils\Payload\Payload;
use App\Services\Utils\Payload\PayloadFactory;
use Exception;

class DatatableExportService
{

    public function __construct() {}

    /**
     * @throws Exception
     */
    public function execute(DatatableRequestDto $dto, string $locale, string $email, string $fullName): Payload
    {
        DatatableExportJob::dispatch($dto, $locale, $email, $fullName);
        return PayloadFactory::success(PayloadMessage::DATA_EXPORTED);
    }


}
