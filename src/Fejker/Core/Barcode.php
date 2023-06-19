<?php

declare(strict_types=1);

namespace Fejker\Core;

use Fejker\Calculator\Ean;
use Fejker\Calculator\Isbn;
use Fejker\Extension\Helper;
use Fejker\Extension\BarcodeExtension;

final class Barcode implements BarcodeExtension
{
    private function ean(int $length = 13): string
    {
        $code = Helper::numerify(str_repeat('#', $length - 1));

        return sprintf('%s%s', $code, Ean::checksum($code));
    }

    public function ean13(): string
    {
        return $this->ean();
    }

    public function ean8(): string
    {
        return $this->ean(8);
    }

    /**
     * Get a random ISBN-10 code
     * @see http://en.wikipedia.org/wiki/International_Standard_Book_Number
     */
    public function isbn10(): string
    {
        $code = Helper::numerify(str_repeat('#', 9));

        return sprintf('%s%s', $code, Isbn::checksum($code));
    }

    /**
     * Get a random ISBN-13 code
     * @see http://en.wikipedia.org/wiki/International_Standard_Book_Number
     */
    public function isbn13(): string
    {
        $code = '97' . mt_rand(8, 9) . Helper::numerify(str_repeat('#', 9));

        return sprintf('%s%s', $code, Ean::checksum($code));
    }
}
