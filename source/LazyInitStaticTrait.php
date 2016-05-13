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
     * @param Closure           $container
     * @param string|array|null $dependency
     * @param mixed[]           $params
     *
     * @return mixed
     *
     * @throws ErrorException
     */
    protected static function lazyInitStatic ( Closure $container, $dependency = null, array $params = [ ] )
    {
        /** @var string $key */
        if ( $dependency === null ) {
            $key = LazyInitHelper::createBacktraceKey();
        } elseif ( is_array( $dependency ) ) {
            $key = LazyInitHelper::createDependencyKey( $dependency );
        } else {
            $key = $dependency;
        }
        if ( !array_key_exists( $key, static::$lazyInitStaticData ) ) {
            static::$lazyInitStaticData[ $key ] = call_user_func_array( $container, $params );
        }

        return static::$lazyInitStaticData[ $key ];
    }
}
