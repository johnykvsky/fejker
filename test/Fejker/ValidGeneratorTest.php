<?php

declare(strict_types=1);

namespace Fejker\Test;

/**
 * @covers \Fejker\ValidGenerator
 */
final class ValidGeneratorTest extends TestCase
{
    public function testValidator(): void
    {
        $this->expectException(\OverflowException::class);

        $validator = static function ($value) {
            return $value !== 0;
        };
        $this->faker->valid($validator, 10)->numberBetween(0, 0);
    }
}
