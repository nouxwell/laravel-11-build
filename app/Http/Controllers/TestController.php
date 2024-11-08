<?php

namespace App\Http\Controllers;


use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class TestController extends Controller
{
    public function __construct() {}


    public function __invoke() {
        $text = 'https://example.com';

        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: 'Custom QR code contents',
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            labelText: 'This is the label',
            labelFont: new OpenSans(20),
            labelAlignment: LabelAlignment::Center,
            logoPath: __DIR__.'/assets/symfony.png',
            logoResizeToWidth: 50,
            logoPunchoutBackground: true
        );

        $result = $builder->build();

// Return the QR code image as a response
        return response($result, 200)
            ->header('Content-Type', $result->getMimeType());
//        $code = "123456789";
//        return response()->json(BarcodeGenerator::generate($code));
    }
}
