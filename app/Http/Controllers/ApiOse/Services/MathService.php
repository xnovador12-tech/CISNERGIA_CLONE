<?php

namespace App\Http\Controllers\ApiOse\Services;

class MathService
{
    // --- Métodos de comparación ---

    public static function isZero(string $amount): bool
    {
        return bccomp(trim($amount), '0', 8) === 0;
    }

    public static function isNegative(string $amount): bool
    {
        return bccomp(trim($amount), '0', 8) === -1;
    }

    public static function isGreaterThanZero(string $amount): bool
    {
        return bccomp(trim($amount), '0', 8) === 1;
    }

    // --- Métodos de cálculo ---

    public static function sum(string $a, string $b, int $decimals = 2): string
    {
        return bcadd($a, $b, max($decimals, 2));
    }

    public static function subtract(string $a, string $b, int $decimals = 2): string
    {
        return bcsub($a, $b, max($decimals, 2));
    }

    public static function multiply(string $a, string $b, int $decimals = 2): string
    {
        return bcmul($a, $b, max($decimals, 2));
    }

    public static function divide(string $a, string $b, int $decimals = 2): string
    {
        if (self::isZero($b)) return "0.00";

        return bcdiv($a, $b, max($decimals, 2));
    }
}
