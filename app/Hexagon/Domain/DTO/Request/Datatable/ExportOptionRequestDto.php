<?php

namespace App\Hexagon\Domain\DTO\Request\Datatable;


use App\Hexagon\Domain\DTO\BaseDto;

class ExportOptionRequestDto extends BaseDto
{
    public string $type;
    public array $columns;
    public string $fileName;
}
