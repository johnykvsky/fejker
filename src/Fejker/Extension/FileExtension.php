<?php

namespace Fejker\Extension;

interface FileExtension extends Extension
{
    /**
     * Get a random MIME type
     *
     * @example 'video/avi'
     */
    public function mimeType(): string;

    /**
     * Get a random file extension (without a dot)
     *
     * @example avi
     */
    public function extension(): string;

    /**
     * Get a full path to a new real file on the system.
     */
    public function filePath(): string;
}