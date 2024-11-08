<?php

namespace App\Services\Utils\Datatable;


use App\Hexagon\Domain\DTO\Request\Datatable\DatatableRequestDto;
use App\Hexagon\Infrastructure\Repository\BaseRepository;

class DatatableService
{
    private BaseRepository $repository;
    public function __construct(BaseRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(DatatableRequestDto $option): array
    {
        return $this->repository->fetchPagedDataForDatatable($option);
    }
}
