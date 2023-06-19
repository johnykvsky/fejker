<?php

declare(strict_types=1);

namespace Fejker\Test;

use Fejker\Extension\NumberExtension;

/**
 * @covers \Fejker\UniqueGenerator
 */
final class UniqueGeneratorTest extends TestCase
{
    public function testUniqueGeneratorKeepsUniquesAcrossExtensions(): void
    {
        $this->expectException(\OverflowException::class);

        for ($i = 0; $i < 3; ++$i) {
            $this->faker->unique()->ext(NumberExtension::class)->numberBetween(0, 1);
        }
    }

    public function testUniqueGeneratorRetries(): void
    {
        $data = [];
        for ($i = 0; $i < 10; ++$i) {
            $data[] = $this->faker->unique()->ext(NumberExtension::class)->numberBetween(0, 9);
        }

        self::assertCount(10, array_unique($data));
    }
}
