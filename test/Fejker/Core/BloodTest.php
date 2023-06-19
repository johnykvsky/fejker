<?php

declare(strict_types=1);

namespace Fejker\Test\Core;

use Fejker\Test\TestCase;
use Fejker\UniqueGenerator;

final class BloodTest extends TestCase
{
    public function testBloodType(): void
    {
        $expected = [
            'A',
            'AB',
            'B',
            'O',
        ];

        $faker = new UniqueGenerator($this->faker);

        $generated = [];

        for ($i = 0; $i < count($expected); ++$i) {
            $generated[] = $faker->bloodType();
        }

        self::assertEqualsCanonicalizing($expected, $generated);
    }

    public function testBloodRh(): void
    {
        $expected = [
            '+',
            '-',
        ];

        $faker = new UniqueGenerator($this->faker);

        $generated = [];

        for ($i = 0; $i < count($expected); ++$i) {
            $generated[] = $faker->bloodRh();
        }

        self::assertEqualsCanonicalizing($expected, $generated);
    }

    public function testBloodGroup(): void
    {
        $expected = [
            'A+',
            'A-',
            'AB+',
            'AB-',
            'B+',
            'B-',
            'O+',
            'O-',
        ];

        $faker = new UniqueGenerator($this->faker);

        $generated = [];

        for ($i = 0; $i < count($expected); ++$i) {
            $generated[] = $faker->bloodGroup();
        }

        self::assertEqualsCanonicalizing($expected, $generated);
    }
}
