<?php

declare(strict_types=1);

namespace Fejker;

use Psr\Container\ContainerInterface;
use Fejker\Container\ContainerBuilder;
use Fejker\Extension\GeneratorAwareExtension;
use Fejker\Extension\ExtensionNotFound;
use Fejker\Extension\FileExtension;
use Fejker\Extension\BloodExtension;
use Fejker\Extension\BarcodeExtension;
use Fejker\Extension\NumberExtension;
use Fejker\Extension\VersionExtension;

class Generator
{
    protected array $providers = [];
    protected array $formatters = [];
    private ContainerInterface $container;

    private ?UniqueGenerator $uniqueGenerator = null;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container ?: ContainerBuilder::getDefault();
    }

    public function ext(string $id): Extension\Extension
    {
        if (!$this->container->has($id)) {
            throw new ExtensionNotFound(sprintf(
                'No Fejker extension with id "%s" was loaded.',
                $id,
            ));
        }

        $extension = $this->container->get($id);
        $extension = new $extension;

        if ($extension instanceof GeneratorAwareExtension) {
            $extension = $extension->withGenerator($this);
        }

        return $extension;
    }

    public function addProvider($provider): void
    {
        array_unshift($this->providers, $provider);

        $this->formatters = [];
    }

    public function getProviders(): array
    {
        return $this->providers;
    }

    /**
     * With the unique generator you are guaranteed to never get the same two
     * values.
     *
     * <code>
     * // will never return twice the same value
     * $faker->unique()->randomElement(array(1, 2, 3));
     * </code>
     *
     * @param bool $reset      If set to true, resets the list of existing values
     * @param int  $maxRetries Maximum number of retries to find a unique value,
     *                         After which an OverflowException is thrown.
     *
     * @throws \OverflowException When no unique value can be found by iterating $maxRetries times
     *
     * @return UniqueGenerator A proxy class returning only non-existing values
     */
    public function unique(bool $reset = false, int $maxRetries = 10000): UniqueGenerator
    {
        if ($reset || $this->uniqueGenerator === null) {
            $this->uniqueGenerator = new UniqueGenerator($this, $maxRetries);
        }

        return $this->uniqueGenerator;
    }

    /**
     * Get a value only some percentage of the time.
     *
     * @param float $weight A probability between 0 and 1, 0 means that we always get the default value.
     */
    public function optional(float $weight = 0.5, mixed $default = null): ChanceGenerator
    {
        return new ChanceGenerator($this, $weight, $default);
    }

    /**
     * To make sure the value meet some criteria, pass a callable that verifies the
     * output. If the validator fails, the generator will try again.
     *
     * The value validity is determined by a function passed as first argument.
     *
     * <code>
     * $values = array();
     * $evenValidator = function ($digit) {
     *   return $digit % 2 === 0;
     * };
     * for ($i=0; $i < 10; $i++) {
     *   $values []= $faker->valid($evenValidator)->randomDigit;
     * }
     * print_r($values); // [0, 4, 8, 4, 2, 6, 0, 8, 8, 6]
     * </code>
     *
     * @param ?\Closure $validator  A function returning true for valid values
     * @param int       $maxRetries Maximum number of retries to find a valid value,
     *                              After which an OverflowException is thrown.
     *
     * @throws \OverflowException When no valid value can be found by iterating $maxRetries times
     *
     * @return ValidGenerator A proxy class returning only valid values
     */
    public function valid(?\Closure $validator = null, int $maxRetries = 10000): ValidGenerator
    {
        return new ValidGenerator($this, $validator, $maxRetries);
    }

    public function seed($seed = null): void
    {
        if ($seed === null) {
            mt_srand();
        } else {
            mt_srand((int) $seed, MT_RAND_PHP);
        }
    }

    public function format($format, array $arguments = [])
    {
        return call_user_func_array($this->getFormatter($format), $arguments);
    }

    public function getFormatter(string $format): callable
    {
        if (isset($this->formatters[$format])) {
            return $this->formatters[$format];
        }

        if (method_exists($this, $format)) {
            $this->formatters[$format] = [$this, $format];

            return $this->formatters[$format];
        }

        // "Fejker\Core\Barcode->ean13"
        if (preg_match('|^([a-zA-Z0-9\\\]+)->([a-zA-Z0-9]+)$|', $format, $matches)) {
            $this->formatters[$format] = [$this->ext($matches[1]), $matches[2]];

            return $this->formatters[$format];
        }

        foreach ($this->providers as $provider) {
            if (method_exists($provider, $format)) {
                $this->formatters[$format] = [$provider, $format];

                return $this->formatters[$format];
            }
        }

        throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    }

    /**
     * Replaces tokens ('{{ tokenName }}') with the result from the token method call
     */
    public function parse(string $string): string
    {
        $callback = function ($matches) {
            return $this->format($matches[1]);
        };

        return preg_replace_callback('/{{\s?(\w+|[\w\\\]+->\w+?)\s?}}/u', $callback, $string);
    }

    public function mimeType(): string
    {
        return $this->ext(FileExtension::class)->mimeType();
    }

    public function fileExtension(): string
    {
        return $this->ext(FileExtension::class)->extension();
    }

    public function filePath(): string
    {
        return $this->ext(FileExtension::class)->filePath();
    }

    public function bloodType(): string
    {
        return $this->ext(BloodExtension::class)->bloodType();
    }

    public function bloodRh(): string
    {
        return $this->ext(BloodExtension::class)->bloodRh();
    }

    public function bloodGroup(): string
    {
        return $this->ext(BloodExtension::class)->bloodGroup();
    }

    public function ean13(): string
    {
        return $this->ext(BarcodeExtension::class)->ean13();
    }

    public function ean8(): string
    {
        return $this->ext(BarcodeExtension::class)->ean8();
    }

    /**
     * Get a random ISBN-10 code
     * @see http://en.wikipedia.org/wiki/International_Standard_Book_Number
     */
    public function isbn10(): string
    {
        return $this->ext(BarcodeExtension::class)->isbn10();
    }

    /**
     * Get a random ISBN-13 code
     * @see http://en.wikipedia.org/wiki/International_Standard_Book_Number
     */
    public function isbn13(): string
    {
        return $this->ext(BarcodeExtension::class)->isbn13();
    }

    public function numberBetween($int1 = 0, $int2 = 2147483647): int
    {
        return $this->ext(NumberExtension::class)->numberBetween((int) $int1, (int) $int2);
    }

    public function randomDigit(): int
    {
        return $this->ext(NumberExtension::class)->randomDigit();
    }

    public function randomDigitNot($except): int
    {
        return $this->ext(NumberExtension::class)->randomDigitNot((int) $except);
    }

    public function randomDigitNotZero(): int
    {
        return $this->ext(NumberExtension::class)->randomDigitNotZero();
    }

    public function randomFloat($nbMaxDecimals = null, $min = 0, $max = null): float
    {
        return $this->ext(NumberExtension::class)->randomFloat(
            $nbMaxDecimals !== null ? (int) $nbMaxDecimals : null,
            (float) $min,
            $max !== null ? (float) $max : null,
        );
    }

    /**
     * Returns a random integer with 0 to $nbDigits digits.
     *
     * The maximum value returned is mt_getrandmax()
     *
     * @param int|null $nbDigits Defaults to a random number between 1 and 9
     * @param bool     $strict   Whether the returned number should have exactly $nbDigits
     *
     * @example 79907610
     */
    public function randomNumber(int|null $nbDigits = null, bool $strict = false): int
    {
        return $this->ext(NumberExtension::class)->randomNumber(
            $nbDigits !== null ? (int) $nbDigits : null,
            $strict,
        );
    }

    /**
     * Get a version number in semantic versioning syntax 2.0.0. (https://semver.org/spec/v2.0.0.html)
     *
     * @param bool $preRelease Pre release parts may be randomly included
     * @param bool $build      Build parts may be randomly included
     *
     * @example 1.0.0
     * @example 1.0.0-alpha.1
     * @example 1.0.0-alpha.1+b71f04d
     */
    public function semver(bool $preRelease = false, bool $build = false): string
    {
        return $this->ext(VersionExtension::class)->semver($preRelease, $build);
    }

    public function __call(string $method, array $attributes)
    {
        return $this->format($method, $attributes);
    }

    public function __destruct()
    {
        $this->seed();
    }

    public function __wakeup()
    {
        $this->formatters = [];
    }
}
