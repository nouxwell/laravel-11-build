<?php

namespace App\Hexagon\Domain\Repository;

use App\Hexagon\Domain\DTO\Request\Auth\RegisterRequestDto;
use App\Hexagon\Domain\DTO\Request\Datatable\DatatableRequestDto;
use App\Hexagon\Domain\DTO\Request\Select\SelectRequestDto;
use App\Models\User;

interface UserInterface
{
    public function register(RegisterRequestDto $dto): int;
    public function verify(int|string $id): array;
    public function find(int|string $id): ?User;
    public function fetchPagedDataForDatatable(DatatableRequestDto $option): array;
    public function fetchPagedDataForSelect(SelectRequestDto $option): array;
}
