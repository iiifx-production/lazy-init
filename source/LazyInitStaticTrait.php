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
     * @return mixed
     */
    protected static function lazyInitStatic ( $value, $key ) {
        # Проверяем наличие кэшированного значения
        if ( !array_key_exists( $key, self::$lazyInitStaticData ) ) {
            # Еще не создано, создаем
            if ( $value instanceof \Closure ) {
                # Это замыкание, выполняем его
                self::$lazyInitStaticData[ $key ] = $value();
            } else {
                # Это просто значение, сохраняем его
                self::$lazyInitStaticData[ $key ] = $value;
            }
        }
        # Возвращаем кэшированный результат
        return self::$lazyInitStaticData[ $key ];
    }

}
