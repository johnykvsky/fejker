<?php

declare(strict_types=1);

namespace Fejker\Provider;

class Address extends Base
{
    protected static array $citySuffix = ['Ville'];
    protected static array $streetSuffix = ['Street'];
    protected static array $cityFormats = [
        '{{firstName}}{{citySuffix}}',
    ];
    protected static array $streetNameFormats = [
        '{{lastName}} {{streetSuffix}}',
    ];
    protected static array $streetAddressFormats = [
        '{{buildingNumber}} {{streetName}}',
    ];
    protected static array $addressFormats = [
        '{{streetAddress}} {{postcode}} {{city}}',
    ];

    protected static array $buildingNumber = ['%#'];
    protected static array $postcode = ['#####'];
    protected static array $country = [];

    public static function citySuffix(): string
    {
        return static::randomElement(static::$citySuffix);
    }

    public static function streetSuffix(): string
    {
        return static::randomElement(static::$streetSuffix);
    }

    public static function buildingNumber(): string
    {
        return static::numerify(static::randomElement(static::$buildingNumber));
    }

    public function city(): string
    {
        $format = static::randomElement(static::$cityFormats);

        return $this->generator->parse($format);
    }

    public function streetName(): string
    {
        $format = static::randomElement(static::$streetNameFormats);

        return $this->generator->parse($format);
    }

    public function streetAddress(): string
    {
        $format = static::randomElement(static::$streetAddressFormats);

        return $this->generator->parse($format);
    }

    public static function postcode(): string
    {
        return static::toUpper(static::bothify(static::randomElement(static::$postcode)));
    }

    public function address(): string
    {
        $format = static::randomElement(static::$addressFormats);

        return $this->generator->parse($format);
    }

    public static function country(): string
    {
        return static::randomElement(static::$country);
    }

    public static function latitude(int|float $min = -90, int|float $max = 90): float
    {
        return static::randomFloat(6, $min, $max);
    }

    public static function longitude(int|float$min = -180, int|float $max = 180): float
    {
        return static::randomFloat(6, $min, $max);
    }

    public static function localCoordinates(): array
    {
        return [
            'latitude' => static::latitude(),
            'longitude' => static::longitude(),
        ];
    }
}
