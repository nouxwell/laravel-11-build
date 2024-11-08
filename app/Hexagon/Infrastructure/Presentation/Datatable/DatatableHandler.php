<?php

namespace App\Hexagon\Infrastructure\Presentation\Datatable;


use App\Hexagon\Domain\DTO\Request\Datatable\DatatableRequestDto;
use App\Services\Utils\Datatable\DatatableService;

class DatatableHandler
{
    private DatatableService $datatableService;

    public function __construct(DatatableService $datatableService) {
        $this->datatableService = $datatableService;
    }

    public function handle(DatatableRequestDto $dto): array
    {
        return $this->datatableService->execute($dto);
    }
}
