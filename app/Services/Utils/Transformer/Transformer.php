<?php

namespace App\Services\Utils\Transformer;

use App\Hexagon\Domain\DTO\BaseDto;
use App\Hexagon\Domain\Exceptions\InvalidClassException;

class Transformer
{
    private DataTransformer $transformer;

    public function __construct(DataTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @throws InvalidClassException
     */
    public function transformer(string $dtoClass, array $validatedData): BaseDto
    {
        return $this->transformer->transform($dtoClass, $validatedData);
    }
}
