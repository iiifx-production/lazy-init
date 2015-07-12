<?php

namespace iiifx\LazyInit;

use Closure;

/**
 * Class LazyInitStaticTrait
 *
 * @package iiifx\LazyInit
 * @author Vitaliy IIIFX Khomenko <iiifx@yandex.com>
 * @link https://github.com/iiifx-production/lazy-init
 */
trait LazyInitStaticTrait {

    /**
     * @var mixed[]
     */
    protected static $lazyInitStaticData = [ ];

    /**
     * @param Closure $container
     * @param string  $key
     * @param mixed[] $params
     *
     * @return mixed
     */
    protected static function lazyInitStatic ( Closure $container, $key, $params = [ ] ) {
        if ( !array_key_exists( $key, static::$lazyInitStaticData ) ) {
            static::$lazyInitStaticData[ $key ] = call_user_func_array( $container, $params );
        }
        return static::$lazyInitStaticData[ $key ];
    }

}
