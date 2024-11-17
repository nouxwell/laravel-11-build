<?php

namespace App\Http\Controllers;

use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class TestController extends Controller
{
    public function __construct() {}


    public function __invoke() {
        // QR kod ayarları
        $renderer = new ImageRenderer(
            new RendererStyle(400), // Boyut (400x400 piksel)
            new SvgImageBackEnd()  // SVG formatında çıktı
        );

        $writer = new Writer($renderer);

        // QR kod içeriği
        $text = 'https://example.com';

        // QR kodu oluştur ve SVG olarak döndür
        $qrCodeSvg = $writer->writeString($text);

        // Tarayıcıda göstermek için SVG içeriğini döndür
        return response($qrCodeSvg, 200, ['Content-Type' => 'image/svg+xml']);

        //İndirmek için
//        $renderer = new ImageRenderer(
//            new RendererStyle(400),
//            new SvgImageBackEnd()
//        );
//
//        $writer = new Writer($renderer);
//
//        $text = 'https://example.com';
//
//        $qrCodeSvg = $writer->writeString($text);
//
//        $fileName = 'qrcode.svg';
//        return response($qrCodeSvg, 200, [
//            'Content-Type' => 'image/svg+xml',
//            'Content-Disposition' => "attachment; filename=\"$fileName\""
//        ]);
    }
}
