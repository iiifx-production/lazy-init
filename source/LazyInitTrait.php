<?php

namespace iiifx\LazyInit;

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
     * @param \Closure $closure
     * @param string   $key
     * @param mixed[]  $params
     *
     * @return mixed
     */
    protected function lazyInit ( $closure, $key, $params = [ ] ) {
        if ( !array_key_exists( $key, $this->lazyInitData ) ) {
            if ( !( $closure instanceof \Closure ) ) {
                throw new \InvalidArgumentException();
            }
            $this->lazyInitData[ $key ] = call_user_func_array( $closure, $params );
        }
        return $this->lazyInitData[ $key ];
    }

}
