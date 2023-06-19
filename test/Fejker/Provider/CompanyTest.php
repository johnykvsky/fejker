<?php

declare(strict_types=1);

namespace Fejker\Test\Provider;

use Fejker\Provider\Company;
use Fejker\Provider\Lorem;
use Fejker\Test\TestCase;

/**
 * @group legacy
 */
final class CompanyTest extends TestCase
{
    public function testJobTitle(): void
    {
        $jobTitle = $this->faker->jobTitle();
        $pattern = '/^[A-Za-z]+$/';
        self::assertMatchesRegularExpression($pattern, $jobTitle);
    }

    protected function getProviders(): iterable
    {
        yield new Company($this->faker);

        yield new Lorem($this->faker);
    }
}
