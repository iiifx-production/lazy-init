<?php

namespace iiifx\LazyInit;

use Closure;
use ErrorException;

/**
 * Class LazyInitTrait.
 *
 * @author  Vitaliy IIIFX Khomenko <iiifx@yandex.com>
 *
 * @link    https://github.com/iiifx-production/lazy-init
 */
trait LazyInitTrait
{
    /**
     * @var mixed[]
     */
    protected $lazyInitData = [ ];

    /**
     * @param Closure     $container
     * @param string|null $key
     * @param mixed[]     $params
     *
     * @return mixed
     *
     * @throws ErrorException
     */
    protected function lazyInit ( Closure $container, $key = null, array $params = [ ] )
    {
        if ( $key === null ) {
            $key = LazyInitHelper::createBacktraceKey();
        }
        if ( !array_key_exists( $key, $this->lazyInitData ) ) {
            $this->lazyInitData[ $key ] = call_user_func_array( $container, $params );
        }

        return $this->lazyInitData[ $key ];
    }
}
