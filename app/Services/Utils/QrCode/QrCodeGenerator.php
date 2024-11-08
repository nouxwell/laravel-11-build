<?php

namespace App\Services\Utils\QrCode;

use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\Exceptions\UnknownTypeException;

class QrCodeGenerator
{
    /**
     * @throws UnknownTypeException
     */
    public static function generate(string $code): array
    {
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($code, $generator::TYPE_CODE_128);
        $barcodeBase64 = base64_encode($barcode);
        return [
            'barcode' => 'data:image/png;base64,' . $barcodeBase64,
            'code' => $code
        ];
    }
}
