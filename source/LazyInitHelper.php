<?php

namespace iiifx\LazyInit;

/**
 * Class LazyInitHelper
 *
 * @package iiifx\LazyInit
 */
class LazyInitHelper {

    use LazyInitStaticTrait;

    public static function lazyInit ( $value, $key, $params = [] ) {
        return self::lazyInitStatic ( $value, $key, $params );
    }

}
