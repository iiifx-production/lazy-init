<?php

namespace iiifx\LazyInit;

use Closure;
use ErrorException;

/**
 * Class LazyInitStaticTrait.
 *
 * @author  Vitaliy IIIFX Khomenko <iiifx@yandex.com>
 *
 * @link    https://github.com/iiifx-production/lazy-init
 */
trait LazyInitStaticTrait
{
    /**
     * @var mixed[]
     */
    protected static $lazyInitStaticData = [ ];

    /**
     * @param Closure     $container
     * @param string|null $key
     * @param mixed[]     $params
     *
     * @return mixed
     *
     * @throws ErrorException
     */
    protected static function lazyInitStatic ( Closure $container, $key = null, array $params = [ ] )
    {
        if ( $key === null ) {
            $key = LazyInitHelper::createBacktraceKey();
        }
        if ( !array_key_exists( $key, static::$lazyInitStaticData ) ) {
            static::$lazyInitStaticData[ $key ] = call_user_func_array( $container, $params );
        }

        return static::$lazyInitStaticData[ $key ];
    }
}
