<?php

namespace App\Hexagon\Infrastructure\Persistence\Auth;

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

class GenerateLoginQrCodeHandler
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
    public function handle(LoginCheckRequestDto $dto): string
    {
        if (!auth()->attempt($dto->all()))
            throw new InvalidCredentialsException();

        $user = auth()->user();
        $google2fa = new Google2FA();
        // Yeni gizli anahtar oluştur
        if (empty($user->two_factor_secret)) {
            $user->two_factor_secret = $google2fa->generateSecretKey();
        }

        $user->two_factor_enabled = true;
        $user->save();

        $content = $google2fa->getQRCodeUrl(
            'Laravel 11 Build',
            $user->email,
            $user->two_factor_secret
        );
        // QR kod ayarları
        $renderer = new ImageRenderer(
            new RendererStyle(400), // Boyut (400x400 piksel)
            new SvgImageBackEnd()  // SVG formatında çıktı
        );
        $writer = new Writer($renderer);
        // QR kodu oluştur ve SVG olarak döndür
        return $writer->writeString($content);
    }
}
