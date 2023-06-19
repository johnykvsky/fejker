<?php

namespace Fejker\Extension;

interface CompanyExtension extends Extension
{
    /**
     * @example 'Acme Ltd'
     */
    public function company(): string;

    /**
     * @example 'Ltd'
     */
    public function companySuffix(): string;

    public function jobTitle(): string;
}
