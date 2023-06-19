<?php

declare(strict_types=1);

namespace Fejker\Test\Extension;

use Fejker\Extension\Extension;
use Fejker\Extension\GeneratorAwareExtensionTrait;
use Fejker\Generator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Fejker\Extension\GeneratorAwareExtensionTrait
 */
final class GeneratorAwareExtensionTest extends TestCase
{
    public function testWithGeneratorClonesExtensionAndSetsGenerator(): void
    {
        $generator = new Generator();

        $extension = new class() implements Extension {
            use GeneratorAwareExtensionTrait;

            public function generator(): Generator
            {
                return $this->generator;
            }
        };

        $mutated = $extension->withGenerator($generator);

        self::assertNotSame($mutated, $extension);
        self::assertSame($generator, $mutated->generator());
    }
}
