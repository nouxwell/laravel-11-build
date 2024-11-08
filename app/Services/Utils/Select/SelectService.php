<?php

namespace App\Services\Utils\Select;


use App\Hexagon\Domain\DTO\Request\Select\SelectRequestDto;
use App\Hexagon\Infrastructure\Repository\BaseRepository;

class SelectService
{
    private BaseRepository $repository;
    public function __construct(BaseRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(SelectRequestDto $option): array
    {
        return $this->repository->fetchPagedDataForSelect($option);
    }
}
