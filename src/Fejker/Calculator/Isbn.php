<?php

declare(strict_types=1);

namespace Fejker\Calculator;

class Isbn
{
    public const VALIDATION_PATTERN_ISBN_10 = '/^\d{9}[0-9X]$/';

    /**
     * ISBN-10 check digit
     * @see http://en.wikipedia.org/wiki/International_Standard_Book_Number#ISBN-10_check_digits
     */
    public static function checksum(string $isbn): string
    {
        // We're calculating check digit for ISBN-10 so, the length of the input should be 9
        $length = 9;

        if (strlen($isbn) !== $length) {
            throw new \LengthException(sprintf('Input length should be equal to %d', $length));
        }

        $digits = str_split($isbn);
        array_walk(
            $digits,
            static function (&$digit, $position): void {
                $digit = (10 - $position) * $digit;
            },
        );
        $result = (11 - array_sum($digits) % 11) % 11;

        // 10 is replaced by X
        return ($result < 10) ? (string) $result : 'X';
    }

    public static function isValid(string $isbn): bool
    {
        if (!preg_match(self::VALIDATION_PATTERN_ISBN_10, $isbn)) {
            return false;
        }

        return self::checksum(substr($isbn, 0, -1)) === substr($isbn, -1);
    }
}
