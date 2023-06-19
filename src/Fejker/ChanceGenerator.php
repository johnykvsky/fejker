<?php
declare(strict_types=1);

namespace Fejker;

use Fejker\Extension\Extension;

/**
 * This generator returns a default value for all called properties
 * and methods. It works with Fejker\Generator::optional().
 *
 * @mixin Generator
 */
class ChanceGenerator
{
    private Extension|Generator $generator;
    private float $weight;
    protected mixed $default;

    public function __construct(Extension|Generator $generator, float $weight, mixed $default = null)
    {
        $this->default = $default;
        $this->generator = $generator;
        $this->weight = $weight;
    }

    public function ext(string $id): self
    {
        return new self($this->generator->ext($id), $this->weight, $this->default);
    }

    public function __call(string $name, array $arguments)
    {
        if (mt_rand(1, 100) <= (100 * $this->weight)) {
            return call_user_func_array([$this->generator, $name], $arguments);
        }

        return $this->default;
    }
}
