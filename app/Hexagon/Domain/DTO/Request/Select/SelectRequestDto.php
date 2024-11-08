<?php

namespace App\Hexagon\Domain\DTO\Request\Select;


use App\Hexagon\Domain\DTO\BaseDto;

class SelectRequestDto extends BaseDto
{
    public int $limit = 50;
    public int $page = 1;
    public ?string $search = null;
    public string|array|null $value = null;
    public string $model;
    public ?array $params = null;
}
