<?php

declare(strict_types=1);

namespace Fejker\Extension;

use Fejker\Generator;

trait GeneratorAwareExtensionTrait
{
    private ?Generator $generator;

    public function withGenerator(Generator $generator): Extension
    {
        $instance = clone $this;
        $instance->generator = $generator;

        return $instance;
    }
}
