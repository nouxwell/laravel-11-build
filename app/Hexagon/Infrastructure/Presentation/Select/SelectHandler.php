<?php

namespace App\Hexagon\Infrastructure\Presentation\Select;


use App\Hexagon\Domain\DTO\Request\Select\SelectRequestDto;
use App\Services\Utils\Select\SelectService;

class SelectHandler
{
    private SelectService $selectService;

    public function __construct(SelectService $selectService) {
        $this->selectService = $selectService;
    }

    public function handle(SelectRequestDto $dto): array
    {
        return $this->selectService->execute($dto);
    }
}
