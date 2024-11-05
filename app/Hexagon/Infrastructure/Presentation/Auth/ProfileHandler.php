<?php

namespace App\Hexagon\Infrastructure\Presentation\Auth;


use App\Hexagon\Domain\DTO\BaseDto;
use App\Hexagon\Domain\DTO\Response\Auth\ProfileResponseDto;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Hexagon\Domain\Exceptions\InvalidCredentialsException;
use App\Services\Utils\Transformer\DataTransformer;

class ProfileHandler
{
    private DataTransformer $transformer;

    public function __construct(DataTransformer $transformer) {
        $this->transformer = $transformer;
    }

    /**
     * @throws InvalidCredentialsException
     * @throws InvalidClassException
     */
    public function handle(): BaseDto
    {
        $user = auth()->user();
        return $this->transformer->transform(ProfileResponseDto::class, $user->attributesToArray());
    }

}
