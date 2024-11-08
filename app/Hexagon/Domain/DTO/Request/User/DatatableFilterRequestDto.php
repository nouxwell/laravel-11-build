<?php

namespace App\Hexagon\Domain\DTO\Request\User;


use App\Hexagon\Domain\DTO\DatatableFilterBaseDto;

class DatatableFilterRequestDto extends DatatableFilterBaseDto
{
    public ?string $name = null;
    public ?string $surname = null;
    public ?string $username = null;
    public ?string $email = null;
    public ?string $entryCode = null;
    public ?bool $softDelete = null;
}
