<?php

namespace iiifx\LazyInit;

use Closure;

/**
 * Class LazyInitHelper
 *
 * @package iiifx\LazyInit
 * @author Vitaliy IIIFX Khomenko <iiifx@yandex.com>
 * @link https://github.com/iiifx-production/lazy-init
 */
class LazyInitHelper {

    use LazyInitStaticTrait;

    /**
     * @param Closure $closure
     * @param string  $key
     * @param mixed[] $params
     *
     * @return mixed
     */
    public static function lazyInit ( Closure $closure, $key, $params = [ ] ) {
        return self::lazyInitStatic( $closure, $key, $params );
    }

}
