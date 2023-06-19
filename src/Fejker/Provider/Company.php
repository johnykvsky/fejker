<?php

declare(strict_types=1);

namespace Fejker\Provider;

class Company extends Base
{
    protected static array $formats = [
        '{{lastName}} {{companySuffix}}',
    ];

    protected static array $companySuffix = ['Ltd'];

    protected static array $jobTitleFormat = [
        '{{word}}',
    ];

    public function company(): string
    {
        $format = static::randomElement(static::$formats);

        return $this->generator->parse($format);
    }

    public static function companySuffix(): string
    {
        return static::randomElement(static::$companySuffix);
    }

    public function jobTitle(): string
    {
        $format = static::randomElement(static::$jobTitleFormat);

        return $this->generator->parse($format);
    }
}
