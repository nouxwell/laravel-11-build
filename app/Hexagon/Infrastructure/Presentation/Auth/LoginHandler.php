<?php

namespace App\Hexagon\Infrastructure\Presentation\Auth;


use App\Hexagon\Domain\DTO\BaseDto;
use App\Hexagon\Domain\DTO\Request\Auth\LoginRequestDto;
use App\Hexagon\Domain\DTO\Response\Auth\LoginResponseDto;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Hexagon\Domain\Exceptions\InvalidCredentialsException;
use App\Services\Utils\Token\GenerateToken;
use App\Services\Utils\Transformer\DataTransformer;

class LoginHandler
{
    private DataTransformer $transformer;

    public function __construct(DataTransformer $transformer) {
        $this->transformer = $transformer;
    }

    /**
     * @throws InvalidCredentialsException
     * @throws InvalidClassException
     */
    public function handle(LoginRequestDto $dto): BaseDto
    {
        if (! $token = auth()->attempt($dto->all()))
            throw new InvalidCredentialsException();

        return $this->transformer->transform(LoginResponseDto::class, GenerateToken::generateAuthTokenResponse($token));
    }
}
