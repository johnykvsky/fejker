<?php

declare(strict_types=1);

namespace Fejker\Test\Provider;

use Fejker\Provider\Medical;
use Fejker\Test\TestCase;

/**
 * @group legacy
 */
final class MedicalTest extends TestCase
{
    public function testBloodType(): void
    {
        self::assertContains($this->faker->bloodType(), ['A', 'AB', 'B', 'O']);
    }

    public function testBloodRh(): void
    {
        self::assertContains($this->faker->bloodRh(), ['+', '-']);
    }

    public function testBloodGroup(): void
    {
        self::assertContains($this->faker->bloodGroup(), ['A+', 'A-', 'AB+', 'AB-', 'B+', 'B-', 'O+', 'O-']);
    }

    protected function getProviders(): iterable
    {
        yield new Medical($this->faker);
    }
}
