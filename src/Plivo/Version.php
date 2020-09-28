<?php

namespace Plivo;


/**
 * Class Version
 * @package Plivo
 */
class Version
{
    /**
     * @const string Default api version
     */
    const DEFAULT_API_VERSION = 'v1';

    /**
     * @const int PHP helper library major version number
     */
    const MAJOR = 5;
    /**
     * @const int PHP helper library minor version number
     */
    const MINOR = 11;
    /**
     * @const int PHP helper library patch number
     */
    const PATCH = 1;
    /**
     * @return string
     */
    public function __toString()
    {
        return implode('.', [self::MAJOR, self::MINOR, self::PATCH]);
    }
}
