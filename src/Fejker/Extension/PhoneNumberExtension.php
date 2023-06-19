<?php

namespace Fejker\Extension;

interface PhoneNumberExtension extends Extension
{
    /**
     * @example '555-123-546'
     */
    public function phoneNumber(): string;

    /**
     * @example +27113456789
     */
    public function e164PhoneNumber(): string;
}
