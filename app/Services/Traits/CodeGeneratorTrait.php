<?php

namespace App\Services\Traits;

use App\Hexagon\Domain\Exceptions\InvalidMaxLengthException;
use App\Hexagon\Domain\Exceptions\InvalidMinLengthException;
use Exception;
use Illuminate\Database\Eloquent\Model;

trait CodeGeneratorTrait
{
    abstract protected function getModel(): Model;

    /**
     * @throws Exception
     */
    public function generateEntryCode(?string $codeTitle = null): string
    {
        $lastCode = $this->getDataLastEntryCode();
        if ($codeTitle !== null) {
            return $this->generateCodeWithTitle($codeTitle, $lastCode);
        }

        return $this->generateCodeWithoutTitle($lastCode);
    }

    private function getDataLastEntryCode(): ?string
    {
        $lastCode = $this->getModel()->orderByDesc('entry_code')->first();
        return $lastCode ? $lastCode->entry_code : '000000';
    }

    /**
     * @throws Exception
     */
    private function generateCodeWithTitle(string $codeTitle, ?string $lastCode = null): string
    {
        try {
            if (str_contains($lastCode, '-')) {
                $parts = explode('-', $lastCode);
                $intVal = intval($parts[1]);
            } else {
                $intVal = intval($lastCode);
            }
            do {
                $increment = str_pad(++$intVal, 6, "0", STR_PAD_LEFT);
            } while ($this->isCodeExists($codeTitle . '-' . $increment));

            return $codeTitle . '-' . $increment;
        } catch (Exception $exception) {
            throw new Exception('Error generating code with title: ' . $exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @throws Exception
     */
    private function generateCodeWithoutTitle(string $lastCode): string
    {
        try {
            $lastCodeInt = intval($lastCode);
            do {
                $increment = str_pad(++$lastCodeInt, 6, "0", STR_PAD_LEFT);
            } while ($this->isCodeExists($increment));

            return $increment;
        } catch (Exception $exception) {
            throw new Exception('Error generating code without title: ' . $exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    private function isCodeExists(string $code): bool
    {
        return $this->getModel()->where('entry_code', $code)->exists();
    }

    // End Code Generator


    // -------------------------------------------- && ----------------------------------------------- //


    // Start Sort Generator

    public function generateSort(): int
    {
        $lastSort = $this->getDataLastSort();
        return $lastSort ? $lastSort + 1 : 1;
    }

    private function getDataLastSort(): ?int
    {
        return $this->getModel()->max('sort_order');
    }

    // End Sort Generator


    /**
     * @throws InvalidMinLengthException
     * @throws InvalidMaxLengthException
     */
    public function generateRandomCode(int $length): string
    {
        if ($length < 1) {
            throw new InvalidMinLengthException("1");
        }

        if ($length > 30) {
            throw new InvalidMaxLengthException("30");
        }

        // Define characters (no spaces)
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=';
        $maxIndex = strlen($characters) - 1;

        // Generate random indices
        $randomIndices = array_map(function() use ($maxIndex) {
            return random_int(0, $maxIndex);
        }, range(1, $length));

        // Map indices to characters and concatenate to form the random code
        return implode('', array_map(function($index) use ($characters) {
            return $characters[$index];
        }, $randomIndices));
    }
}
