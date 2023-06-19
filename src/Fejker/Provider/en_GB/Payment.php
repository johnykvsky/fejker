<?php

declare(strict_types=1);

namespace Fejker\Provider\en_GB;

class Payment extends \Fejker\Provider\Payment
{
    /**
     * International Bank Account Number (IBAN)
     * @see http://en.wikipedia.org/wiki/International_Bank_Account_Number
     */
    public static function bankAccountNumber(string $prefix = '', string $countryCode = 'GB', ?int $length = null)
    {
        return static::iban($countryCode, $prefix, $length);
    }
}
