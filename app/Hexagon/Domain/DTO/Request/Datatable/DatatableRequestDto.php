<?php

namespace App\Hexagon\Domain\DTO\Request\Datatable;


use App\Hexagon\Domain\DTO\BaseDto;

class DatatableRequestDto extends BaseDto
{
    public ?string $column = null;
    public ?array $filters = [];
    public int $limit = 50;
    public ?int $id = null;
    public int $page = 1;
    public string $sort = "desc";
    public ?string $search = null;
    public string $model;
    public ?ExportOptionRequestDto $exportOption = null;


    public static function buildFromArray(array $parameters = []): DatatableRequestDto
    {
        if (!empty($parameters['exportOption']))
            $parameters['exportOption'] = ExportOptionRequestDto::from($parameters['exportOption']);

        return parent::from($parameters);
    }
}
