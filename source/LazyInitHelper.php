<?php

namespace iiifx\LazyInit;

use Closure;
use ErrorException;

/**
 * Class LazyInitHelper.
 *
 * @author Vitaliy IIIFX Khomenko <iiifx@yandex.com>
 *
 * @link   https://github.com/iiifx-production/lazy-init
 */
class LazyInitHelper
{
    use LazyInitStaticTrait;

    /**
     *
     */
    const PART_SEPARATOR = '#';

    /**
     * @param Closure     $closure
     * @param string|null $key
     * @param mixed[]     $params
     *
     * @return mixed
     *
     * @throws ErrorException
     */
    public static function lazyInit ( Closure $closure, $key = null, array $params = [ ] )
    {
        if ( $key === null ) {
            $key = static::createBacktraceKey();
        }

        return static::lazyInitStatic( $closure, $key, $params );
    }

    /**
     * @param int $backtraceDepth
     *
     * @return string
     *
     * @throws ErrorException
     */
    public static function createBacktraceKey ( $backtraceDepth = 3 )
    {
        if ( $backtraceData = static::createBacktraceData( $backtraceDepth ) ) {
            return implode( static::PART_SEPARATOR, $backtraceData );
        }
        throw new ErrorException( 'Unable to create BacktraceKey.' );
    }

    /**
     * @param int $backtraceDepth
     *
     * @return array
     *
     * @throws ErrorException
     */
    public static function createBacktraceData ( $backtraceDepth = 0 )
    {
        $backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, $backtraceDepth );
        $backtraceKey = $backtraceDepth - 1;
        if ( isset( $backtrace[ $backtraceKey ][ 'file' ], $backtrace[ $backtraceKey ][ 'line' ] ) ) {
            $parts = [ ];
            $parts[] = $backtrace[ $backtraceKey ][ 'file' ];
            $parts[] = $backtrace[ $backtraceKey ][ 'line' ];

            return $parts;
        }
        throw new ErrorException( 'Unable to create BacktraceData.' );
    }
}
