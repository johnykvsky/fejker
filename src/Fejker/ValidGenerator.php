<?php

declare(strict_types=1);

namespace Fejker;

use Fejker\Extension\Extension;

/**
 * Proxy for other generators, to return only valid values. Works with
 * Fejker\Generator\Base->valid()
 *
 * @mixin Generator
 */
class ValidGenerator
{
    protected Extension|Generator $generator;
    protected $validator;
    protected int $maxRetries;

    public function __construct(Extension|Generator $generator, callable|null $validator = null, int $maxRetries = 10000)
    {
        if (null === $validator) {
            $validator = static function () {
                return true;
            };
        }

        $this->generator = $generator;
        $this->validator = $validator;
        $this->maxRetries = $maxRetries;
    }

    public function ext(string $id): self
    {
        return new self($this->generator->ext($id), $this->validator, $this->maxRetries);
    }

    public function __call(string $name, array $arguments): mixed
    {
        $i = 0;

        do {
            $res = call_user_func_array([$this->generator, $name], $arguments);
            ++$i;

            if ($i > $this->maxRetries) {
                throw new \OverflowException(sprintf('Maximum retries of %d reached without finding a valid value', $this->maxRetries));
            }
        } while (!call_user_func($this->validator, $res));

        return $res;
    }
}
