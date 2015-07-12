<?php

namespace iiifx\LazyInit;

use Closure;

/**
 * Class LazyInitTrait
 *
 * @package iiifx\LazyInit
 */
trait LazyInitTrait {

    /**
     * @var mixed[]
     */
    protected $lazyInitData = [ ];

    /**
     * @param Closure $container
     * @param string  $key
     * @param mixed[] $params
     *
     * @return mixed
     */
    protected function lazyInit ( Closure $container, $key, $params = [ ] ) {
        if ( !array_key_exists( $key, $this->lazyInitData ) ) {
            $this->lazyInitData[ $key ] = call_user_func_array( $container, $params );
        }
        return $this->lazyInitData[ $key ];
    }

}
