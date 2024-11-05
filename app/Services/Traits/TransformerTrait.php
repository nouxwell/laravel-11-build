<?php

namespace App\Services\Traits;

use App\Hexagon\Domain\DTO\BaseDto;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Services\Utils\Transformer\DataTransformer;

trait TransformerTrait
{
    private DataTransformer $transformer;

    public function __construct(DataTransformer $transformer)
    {
        $this->transformer = $transformer;
    }


    /**
     * @throws InvalidClassException
     */
    public function transformToDTO(string $dtoClass, array $validatedData): BaseDto
    {
        return $this->transformer->transform($dtoClass, $validatedData);
    }

}
