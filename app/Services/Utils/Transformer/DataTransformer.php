<?php

namespace App\Services\Utils\Transformer;

use App\Hexagon\Domain\DTO\BaseDto;
use App\Hexagon\Domain\Exceptions\InvalidClassException;

class DataTransformer
{
    /**
     * @throws InvalidClassException
     */
    public function transform(string $dtoClass, array $validatedData): BaseDto
    {
        if (!is_subclass_of($dtoClass, BaseDto::class))
            throw new InvalidClassException($dtoClass);

        return $dtoClass::from($validatedData);
    }
}
