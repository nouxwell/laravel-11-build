<?php

namespace App\Services\Utils\Payload;

use Symfony\Component\HttpFoundation\Response;

class PayloadFactory
{
    /**
     * @param string $message
     * @param array|null $localeOptions
     * @param array|null $data
     * @param int $code
     * @return Payload
     */
    public static function success(string $message, ?array $localeOptions = [], ?array $data = [], int $code = Response::HTTP_OK): Payload
    {
        $message = self::getTranslatedMessage($message, $localeOptions);
        return (new Payload())
            ->setCode($code)
            ->setStatus(true)
            ->setMessage($message)
            ->setData($data);
    }

    /**
     * @param string $message
     * @param array|null $localeOptions
     * @param array|null $errors
     * @param int $code
     * @return Payload
     */
    public static function error(string $message, ?array $localeOptions = [], ?array $errors = [], int $code = Response::HTTP_INTERNAL_SERVER_ERROR): Payload
    {
        $message = self::getTranslatedMessage($message, $localeOptions);
        return (new Payload())
            ->setCode($code)
            ->setStatus(false)
            ->setMessage($message)
            ->setErrors($errors);
    }

    /**
     * @param string $message
     * @param array|null $localeOptions
     * @return string
     */
    private static function getTranslatedMessage(string $message, ?array $localeOptions): string
    {
        // Mesajı yerelleştirin (varsa)
        $translatedMessage = __($message);
        // Yerelleştirilmiş değerlerle mesajı değiştirmek için yer tutucuları kullanın
        if ($localeOptions) {
            foreach ($localeOptions as $key => $value) {
                $value = __($value);
                $translatedMessage = str_replace(':' . $key, $value, $translatedMessage);
            }
        }

        return $translatedMessage;
    }
}
