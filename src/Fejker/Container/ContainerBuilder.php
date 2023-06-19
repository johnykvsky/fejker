<?php

declare(strict_types=1);

namespace Fejker\Container;

use Fejker\Core;
use Fejker\Extension\BarcodeExtension;
use Fejker\Extension\BloodExtension;
use Fejker\Extension\ColorExtension;
use Fejker\Extension\DateTimeExtension;
use Fejker\Extension\FileExtension;
use Fejker\Extension\NumberExtension;
use Fejker\Extension\UuidExtension;
use Fejker\Extension\VersionExtension;
use Psr\Container\ContainerInterface;
use PHPWatch\SimpleContainer\Container;

final class ContainerBuilder
{
    /**
     * @var array<string, callable|object|string>
     */
    private array $definitions = [];

    private const DEFAULT_EXTENSIONS = [
        BarcodeExtension::class => Core\Barcode::class,
        BloodExtension::class => Core\Blood::class,
        ColorExtension::class => Core\Color::class,
        DateTimeExtension::class => Core\DateTime::class,
        FileExtension::class => Core\File::class,
        NumberExtension::class => Core\Number::class,
        VersionExtension::class => Core\Version::class,
        UuidExtension::class => Core\Uuid::class,
    ];

    /**
     * @param callable|object|string $value
     *
     * @throws \InvalidArgumentException
     */
    public function add($value, ?string $name = null): self
    {
        if (!is_string($value) && !is_callable($value) && !is_object($value)) {
            throw new \InvalidArgumentException(sprintf('First argument to "%s::add()" must be a string, callable or object.', self::class,));
        }

        $this->definitions[$this->getName($name, $value)] = $value;

        return $this;
    }

    public function build(): ContainerInterface
    {
        $container = new Container();
        foreach ($this->definitions as $id => $definition) {
            $container->set($id, $definition);
        }

        return $container;
    }

    public static function getDefault(): ContainerInterface
    {
        $instance = new self();

        foreach (self::DEFAULT_EXTENSIONS as $id => $definition) {
            $instance->definitions[$id] = $definition;
        }

        return $instance->build();
    }

    private function getName(?string $name, $value): string
    {
        if ($name !== null) {
            return $name;
        }

        if (is_string($value)) {
            return $value;
        }

        if (is_object($value)) {
            return get_class($value);
        }

        throw new \InvalidArgumentException(sprintf('Second argument to "%s::add()" is required not passing a string or object as first argument', self::class,));
    }
}
