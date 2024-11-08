<?php

namespace App\Hexagon\Domain\Repository;

use App\Hexagon\Domain\DTO\Request\Auth\RegisterRequestDto;
use App\Hexagon\Domain\DTO\Request\Datatable\DatatableRequestDto;
use App\Hexagon\Domain\DTO\Request\Select\SelectRequestDto;

interface UserInterface
{
    public function register(RegisterRequestDto $dto): void;
    public function fetchPagedDataForDatatable(DatatableRequestDto $option): array;
    public function fetchPagedDataForSelect(SelectRequestDto $option): array;
}
