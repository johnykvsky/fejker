<?php

declare(strict_types=1);

namespace Fejker\Test;

use Fejker\ChanceGenerator;
use Fejker\Generator;

final class ChanceGeneratorTest extends TestCase
{
    /**
     * @group legacy
     */
    public function testGeneratorReturnsNullByDefault(): void
    {
        $generator = (new Generator())->optional(0.5);
        self::assertNull($generator->value());
    }


    /**
     * @group legacy
     */
    public function testGeneratorReturnsDefaultValueForAnyMethodCall(): void
    {
        $generator = (new Generator())->optional(0.5, 123);
        self::assertSame(123, $generator->foobar());
    }
}
