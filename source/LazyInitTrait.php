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
     * @param mixed|\Callable $value
     * @param string          $key
     *
     * @param array           $params
     *
     * @return mixed
     */
    protected function lazyInit ( $value, $key, $params = [] ) {
        # Проверяем наличие кэшированного значения
        if ( !array_key_exists( $key, $this->lazyInitData ) ) {
            # Еще не создано, создаем
            if ( $value instanceof \Closure ) {
                # Это замыкание, выполняем его
                $this->lazyInitData[ $key ] = call_user_func_array( $value, $params );
            } else {
                # Это просто значение, сохраняем его
                $this->lazyInitData[ $key ] = $value;
            }
        }
        # Возвращаем кэшированный результат
        return $this->lazyInitData[ $key ];
    }

}
