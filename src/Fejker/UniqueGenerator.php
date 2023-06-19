<?php

declare(strict_types=1);

namespace Fejker;

use Fejker\Extension\Extension;

/**
 * Proxy for other generators that returns only unique values.
 *
 * Instantiated through @see Generator::unique().
 *
 * @mixin Generator
 */
class UniqueGenerator
{
    protected Extension|Generator $generator;
    protected int $maxRetries;

    /**
     * Maps from method names to a map with serialized result keys.
     *
     * @example [
     *   'phone' => ['0123' => null],
     *   'city' => ['London' => null, 'Tokyo' => null],
     * ]
     *
     * @var array<string, array<string, null>>
     */
    protected array $uniques = [];

    public function __construct(Extension|Generator $generator, int $maxRetries = 10000, array &$uniques = [])
    {
        $this->generator = $generator;
        $this->maxRetries = $maxRetries;
        $this->uniques = &$uniques;
    }

    public function ext(string $id): self
    {
        return new self($this->generator->ext($id), $this->maxRetries, $this->uniques);
    }

    public function __call(string $name, array $arguments)
    {
        if (!isset($this->uniques[$name])) {
            $this->uniques[$name] = [];
        }
        $i = 0;

        do {
            $res = call_user_func_array([$this->generator, $name], $arguments);
            ++$i;

            if ($i > $this->maxRetries) {
                throw new \OverflowException(sprintf('Maximum retries of %d reached without finding a unique value', $this->maxRetries));
            }
        } while (array_key_exists(serialize($res), $this->uniques[$name]));
        $this->uniques[$name][serialize($res)] = null;

        return $res;
    }
}
