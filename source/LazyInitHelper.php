<?php

namespace iiifx\LazyInit;

use Closure;
use ErrorException;

/**
 * Class LazyInitHelper.
 *
 * @author  Vitaliy IIIFX Khomenko <iiifx@yandex.com>
 *
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
     *
     * @throws ErrorException
     */
    public static function lazyInit(Closure $closure, $key = null, array $params = [])
    {
        if ($key === null) {
            $key = static::createBacktraceKey();
        }

        return static::lazyInitStatic($closure, $key, $params);
    }

    /**
     * @return string
     *
     * @throws ErrorException
     */
    public static function createBacktraceKey()
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        if (isset($backtrace[ 1 ][ 'file' ], $backtrace[ 1 ][ 'line' ])) {
            $parts = [];
            $parts[] = $backtrace[ 1 ][ 'file' ];
            $parts[] = $backtrace[ 1 ][ 'line' ];

            return md5(implode('#', $parts));
        }
        throw new ErrorException('Unable to create BacktraceKey.');
    }
}
