<?php

namespace iiifx\LazyInit;

/**
 * Class LazyInitStaticTrait
 *
 * @package iiifx\LazyInit
 */
trait LazyInitStaticTrait {

    /**
     * @var mixed[]
     */
    protected static $lazyInitStaticData = [ ];

    /**
     * @param \Closure $closure
     * @param string   $key
     * @param mixed[]  $params
     *
     * @return mixed
     */
    protected static function lazyInitStatic ( $closure, $key, $params = [ ] ) {
        if ( !array_key_exists( $key, static::$lazyInitStaticData ) ) {
            if ( !( $closure instanceof \Closure ) ) {
                throw new \InvalidArgumentException();
            }
            static::$lazyInitStaticData[ $key ] = call_user_func_array( $closure, $params );
        }
        return static::$lazyInitStaticData[ $key ];
    }

}
