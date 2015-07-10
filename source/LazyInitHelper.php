<?php

namespace iiifx\LazyInit;

/**
 * Class LazyInitHelper
 *
 * @package iiifx\LazyInit
 */
class LazyInitHelper {

    use LazyInitStaticTrait;

    /**
     * @param \Closure $closure
     * @param string   $key
     * @param mixed[]  $params
     *
     * @return mixed
     */
    public static function lazyInit ( $closure, $key, $params = [ ] ) {
        return self::lazyInitStatic( $closure, $key, $params );
    }

}
