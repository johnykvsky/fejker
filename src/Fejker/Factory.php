<?php

declare(strict_types=1);

namespace Fejker;

class Factory
{
    public const DEFAULT_LOCALE = 'en_US';
    private const DEFAULT_PROVIDERS = [
        'Address',
        'Biased',
        'Color',
        'Company',
        'DateTime',
        'Internet',
        'Lorem',
        'Medical',
        'Miscellaneous',
        'Payment',
        'Person',
        'PhoneNumber',
        'Text',
        'UserAgent',
        'Uuid'
    ];

    public static function create(string $locale = self::DEFAULT_LOCALE): Generator
    {
        $generator = new Generator();

        foreach (self::DEFAULT_PROVIDERS as $provider) {
            $providerClassName = self::getProviderClassname($provider, $locale);
            $generator->addProvider(new $providerClassName($generator));
        }

        return $generator;
    }

    protected static function getProviderClassname(string $provider, string $locale = ''): string
    {
        if ($providerClass = self::findProviderClassname($provider, $locale)) {
            return $providerClass;
        }
        // fallback to default locale
        if ($providerClass = self::findProviderClassname($provider, static::DEFAULT_LOCALE)) {
            return $providerClass;
        }
        // fallback to no locale
        if ($providerClass = self::findProviderClassname($provider)) {
            return $providerClass;
        }

        throw new \InvalidArgumentException(sprintf('Unable to find provider "%s" with locale "%s"', $provider, $locale));
    }

    protected static function findProviderClassname(string $provider, string $locale = ''): ?string
    {
        $providerClass = 'Fejker\\' . ($locale ? sprintf('Provider\%s\%s', $locale, $provider) : sprintf('Provider\%s', $provider));

        if (class_exists($providerClass, true)) {
            return $providerClass;
        }

        return null;
    }
}
