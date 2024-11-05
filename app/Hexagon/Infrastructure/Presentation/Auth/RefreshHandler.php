<?php

namespace App\Hexagon\Infrastructure\Presentation\Auth;


use App\Hexagon\Domain\DTO\BaseDto;
use App\Hexagon\Domain\DTO\Response\Auth\RefreshResponseDto;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Services\Utils\Token\GenerateToken;
use App\Services\Utils\Transformer\DataTransformer;

class RefreshHandler
{
    private DataTransformer $transformer;

    public function __construct(DataTransformer $transformer) {
        $this->transformer = $transformer;
    }

    /**
     * @throws InvalidClassException
     */
    public function handle(): BaseDto
    {
        $refresh = auth()->refresh();
        return $this->transformer->transform(RefreshResponseDto::class, GenerateToken::generateAuthTokenResponse($refresh));
    }

}
