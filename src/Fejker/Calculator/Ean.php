<?php

declare(strict_types=1);

namespace Fejker\Calculator;

class Ean
{
    public const VALIDATION_PATTERN = '/^(?:\d{8}|\d{13})$/';

    /**
     * @see https://en.wikipedia.org/wiki/International_Article_Number
     */
    public static function checksum(string $digits): int
    {
        $sequence = (strlen($digits) + 1) === 8 ? [3, 1] : [1, 3];
        $sums = 0;

        foreach (str_split($digits) as $n => $digit) {
            $sums += ((int) $digit) * $sequence[$n % 2];
        }

        return (10 - $sums % 10) % 10;
    }

    public static function isValid(string $ean): bool
    {
        if (!preg_match(self::VALIDATION_PATTERN, $ean)) {
            return false;
        }

        return self::checksum(substr($ean, 0, -1)) === (int) substr($ean, -1);
    }
}
