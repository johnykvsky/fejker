<?php

declare(strict_types=1);

namespace Fejker\Test\Provider\en_GB;

use Fejker\Provider\en_GB\Person;
use Fejker\Test\TestCase;

/**
 * @group legacy
 */
final class PersonTest extends TestCase
{
    public function testNationalInsuranceNumber(): void
    {
        $result = $this->faker->nino();

        self::assertMatchesRegularExpression('/^[A-Z]{2}\d{6}[A-Z]{1}$/', $result);

        self::assertNotContains($result[0], ['D', 'F', 'I', 'Q', 'U', 'V']);
        self::assertNotContains($result[1], ['D', 'F', 'I', 'Q', 'U', 'V']);
        self::assertNotContains($result, ['BG', 'GB', 'NK', 'KN', 'TN', 'NT', 'ZZ']);
        self::assertNotSame('O', $result[1]);
    }

    protected function getProviders(): iterable
    {
        yield new Person($this->faker);
    }
}
