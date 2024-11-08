<?php

namespace App\Services\Utils;

use Stevebauman\Purify\Facades\Purify;

class DataCleaner
{
    public static function cleanData(array $validatedData): array
    {
        return array_map(function ($value) {
            if (is_bool($value) || empty($value))
                return $value;

            return Purify::clean($value);
        }, $validatedData);
    }
}
