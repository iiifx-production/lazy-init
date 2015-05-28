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
     * @param mixed|\Closure $value
     * @param string         $key
     *
     * @param array          $params
     *
     * @return mixed
     */
    protected static function lazyInitStatic ( $value, $key, $params = [] ) {
        # Проверяем наличие кэшированного значения
        if ( !array_key_exists( $key, self::$lazyInitStaticData ) ) {
            # Еще не создано, создаем
            if ( $value instanceof \Closure ) {
                # Это замыкание, выполняем его
                self::$lazyInitStaticData[ $key ] = call_user_func_array( $value, $params );
            } else {
                # Это просто значение, сохраняем его
                self::$lazyInitStaticData[ $key ] = $value;
            }
        }
        # Возвращаем кэшированный результат
        return self::$lazyInitStaticData[ $key ];
    }

}
