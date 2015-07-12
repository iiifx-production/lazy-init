# LazyInit

LazyInit - хелпер для быстрого создания методов ленивой(отложенной) инициализации.

[![Latest Version on Packagist][ico-version]][link-packagist] [![Build Status][ico-travis]][link-travis] [![Software License][ico-license]](LICENSE.md) [![Total Downloads][ico-downloads]][link-downloads]

Отложенная (ленивая) инициализация ([Lazy initialization][link-wikipedia]) - приём в программировании, когда некоторая ресурсоёмкая операция (создание объекта, вычисление значения) выполняется непосредственно перед тем, как будет использован её результат. Таким образом, инициализация выполняется «по требованию», а не заблаговременно.

Классический пример использования:
``` php
class DeepThought {

    protected $answer;

    public function getAnswer () {
        if ( is_null( $this->answer ) ) {
            $this->answer = 42;
        }
        return $this->answer;
    }

}

$deepThought = new DeepThought();
echo $deepThought->getAnswer(); # 42
``` 

Аналогичный пример, но с использованием LazyInit:
``` php
class DeepThought {

    use \iiifx\LazyInit\LazyInitTrait;

    public function getAnswer () {
        return $this->lazyInit( function () {
            return 42;
        }, __METHOD__ );
    }

}

$deepThought = new DeepThought();
echo $deepThought->getAnswer(); # 42
```

## Установка

Используя Composer:

``` bash
$ composer require "iiifx-production/lazy-init:0.2.*"
```

## Использование

LazyInitTrait содержит метод lazyInit() и свойство $lazyInitData, в котором буферизирует результаты вычислений.

#### lazyInit( $container, $key, $params = [] ) :

- $closure - Closure-контейнер, содержащий в себе вычисления, должен вернуть результат.
- $key - Ключ для сохранения результата вычисления Closure-контейнера, как правило это __METHOD__.
- $params - Дополнительные переменные, которые будут переданы в Closure-контейнер при его запуске.

Простой геттер:
``` php
/**
 * @return string
 */
public function getDate () {
    return $this->lazyInit( function () {
        return date( 'd.m.Y' );
    }, __METHOD__ );
}
```

Геттер с зависимостью от входящего значения:
``` php
/**
 * @param string $string
 *
 * @return mixed[]
 */
public function parseString ( $string ) {
    return $this->lazyInit( function () use ( $string ) {
        return explode( ':', $string );
    }, __METHOD__ . $string );
}

/**
 * @param int $timastamp
 *
 * @return string
 */
public function formatTimastamp ( $timastamp ) {
    return $this->lazyInit( function ( $t ) {
        return date( 'd.m.Y', $t );
    }, __METHOD__ . $timastamp, [ $timastamp ] );
}
```

## Важно

@TODO

## Тесты

[![Build Status][ico-travis]][link-travis]

## Лицензия

[![Software License][ico-license]](LICENSE.md)


[ico-version]: https://img.shields.io/packagist/v/iiifx-production/lazy-init.svg
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-downloads]: https://img.shields.io/packagist/dt/iiifx-production/lazy-init.svg
[ico-travis2]: https://img.shields.io/travis/thephpleague/:package_name/master.svg
[ico-travis]: https://travis-ci.org/iiifx-production/lazy-init.svg

[link-packagist]: https://packagist.org/packages/iiifx-production/lazy-init
[link-downloads]: https://packagist.org/packages/iiifx-production/lazy-init
[link-travis]: https://travis-ci.org/iiifx-production/lazy-init
[link-wikipedia]: https://ru.wikipedia.org/wiki/%D0%9E%D1%82%D0%BB%D0%BE%D0%B6%D0%B5%D0%BD%D0%BD%D0%B0%D1%8F_%D0%B8%D0%BD%D0%B8%D1%86%D0%B8%D0%B0%D0%BB%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D1%8F
