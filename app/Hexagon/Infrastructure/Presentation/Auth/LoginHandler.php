<?php

namespace App\Hexagon\Infrastructure\Presentation\Auth;


use App\Hexagon\Domain\DTO\BaseDto;
use App\Hexagon\Domain\DTO\Request\Auth\LoginRequestDto;
use App\Hexagon\Domain\DTO\Response\Auth\LoginResponseDto;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Hexagon\Domain\Exceptions\InvalidCredentialsException;
use App\Hexagon\Domain\Exceptions\UserNotVerifiedException;
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
     * @throws UserNotVerifiedException
     */
    public function handle(LoginRequestDto $dto): BaseDto
    {
        if (! $token = auth()->attempt(['email' => $dto->email, 'password' => $dto->password]))
            throw new InvalidCredentialsException();

        if (!auth()->user()->hasVerifiedEmail())
            throw new UserNotVerifiedException();

        return $this->transformer->transform(LoginResponseDto::class, GenerateToken::generateAuthTokenResponse($token));
    }
}
