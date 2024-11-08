<?php

namespace App\Hexagon\Infrastructure\Repository;

use App\Hexagon\Domain\DTO\Request\Datatable\DatatableRequestDto;
use App\Hexagon\Domain\DTO\Request\Select\SelectRequestDto;

abstract class BaseRepository
{
    abstract protected function fetchPagedDataForDatatable(DatatableRequestDto $option): array;
    abstract protected function fetchPagedDataForSelect(SelectRequestDto $option): array;
}
