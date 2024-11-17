<?php

namespace App\Hexagon\Infrastructure\Presentation\Auth;


use App\Hexagon\Domain\DTO\Request\Auth\LoginCheckRequestDto;
use App\Hexagon\Domain\Exceptions\InvalidClassException;
use App\Hexagon\Domain\Exceptions\InvalidCredentialsException;
use App\Hexagon\Domain\Exceptions\UserNotVerifiedException;
use App\Hexagon\Domain\Repository\UserInterface;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use PragmaRX\Google2FA\Google2FA;

class LoginCheckHandler
{
    private UserInterface $user;

    public function __construct(UserInterface $user) {
        $this->user = $user;
    }

    /**
     * @throws InvalidCredentialsException
     * @throws InvalidClassException
     * @throws UserNotVerifiedException
     */
    public function handle(LoginCheckRequestDto $dto): array
    {
        if (!auth()->attempt($dto->all()))
            throw new InvalidCredentialsException();

        $twoFactorStatus = false;
        if (auth()->user()->two_factor_enabled) {
            $twoFactorStatus = true;
            if (empty(auth()->user()->two_factor_secret)) {
                $qrCodeUrl = $this->generateQrCodeTwoFactor();
                return [
                    'twoFactorStatus' => $twoFactorStatus,
                    'qrCode' => $qrCodeUrl
                ];
            }
        }
        return [
            'twoFactorStatus' => $twoFactorStatus,
        ];
    }

    private function generateQrCodeTwoFactor(): string
    {
        $user = auth()->user();
        $google2fa = new Google2FA();
        // Yeni gizli anahtar oluştur
        $user->two_factor_secret = $google2fa->generateSecretKey();
        $user->two_factor_enabled = true;
        $user->save();

        return $google2fa->getQRCodeUrl(
            'Laravel 11 Build',
            $user->email,
            $user->two_factor_secret
        );
    }
}
