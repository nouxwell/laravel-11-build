<?php

namespace App\Hexagon\Domain\DTO;

use Spatie\LaravelData\Data;

class DatatableFilterBaseDto extends Data
{
    public function toArray(): array
    {
        return array_map(function ($value) {
            return is_string($value) ? htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8') : $value;
        }, get_object_vars($this));
    }
}
