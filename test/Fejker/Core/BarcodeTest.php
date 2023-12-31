<?php

declare(strict_types=1);

namespace Fejker\Test\Core;

use Fejker\Calculator\Ean;
use Fejker\Calculator\Isbn;
use Fejker\Test\TestCase;

final class BarcodeTest extends TestCase
{
    public function testEan8(): void
    {
        $code = $this->faker->ean8();
        self::assertMatchesRegularExpression('/^\d{8}$/i', $code);
        self::assertTrue(Ean::isValid($code));
    }

    public function testEan13(): void
    {
        $code = $this->faker->ean13();
        self::assertMatchesRegularExpression('/^\d{13}$/i', $code);
        self::assertTrue(Ean::isValid($code));
    }

    public function testIsbn10(): void
    {
        $code = $this->faker->isbn10();
        self::assertMatchesRegularExpression('/^\d{9}[0-9X]$/i', $code);
        self::assertTrue(Isbn::isValid($code));
    }

    public function testIsbn13(): void
    {
        $code = $this->faker->isbn13();
        self::assertMatchesRegularExpression('/^\d{13}$/i', $code);
        self::assertTrue(Ean::isValid($code));
    }
}
