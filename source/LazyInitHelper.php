<?php

namespace iiifx\LazyInit;

use Closure;
use ErrorException;

/**
 * Class LazyInitHelper
 *
 * @package iiifx\LazyInit
 * @author  Vitaliy IIIFX Khomenko <iiifx@yandex.com>
 * @link    https://github.com/iiifx-production/lazy-init
 */
class LazyInitHelper
{
    use LazyInitStaticTrait;

    /**
     * @param Closure     $closure
     * @param string|null $key
     * @param mixed[]     $params
     *
     * @return mixed
     */
    public static function lazyInit ( Closure $closure, $key = NULL, $params = [ ] )
    {
        if ( is_null( $key ) ) {
            $key = LazyInitHelper::createBacktraceKey();
        }
        return self::lazyInitStatic( $closure, $key, $params );
    }

    /**
     * @return string
     *
     * @throws ErrorException
     */
    public static function createBacktraceKey ()
    {
        $backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2 );
        if ( isset( $backtrace[ 1 ][ 'file' ] ) && isset( $backtrace[ 1 ][ 'line' ] ) ) {
            $parts = [ ];
            $parts[] = $backtrace[ 1 ][ 'file' ];
            $parts[] = $backtrace[ 1 ][ 'line' ];
            return md5( implode( '#', $parts ) );
        }
        throw new ErrorException();
    }
}
