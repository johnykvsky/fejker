<?php

declare(strict_types=1);

namespace Fejker\Extension;

use Fejker\Generator;

interface GeneratorAwareExtension extends Extension
{
    /**
     * This method MUST be implemented in such a way as to retain the
     * immutability of the extension, and MUST return an instance that has the
     * new Generator.
     */
    public function withGenerator(Generator $generator): Extension;
}
