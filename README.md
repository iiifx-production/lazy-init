# LazyInit

**LazyInit** - хелпер для быстрого создания методов ленивой(отложенной) инициализации.

[![Latest Version on Packagist][ico-version]][link-packagist] [![Build Status][ico-travis]][link-travis] [![Software License][ico-license]](LICENSE.md) [![Total Downloads][ico-downloads]][link-downloads]

**Отложенная (ленивая) инициализация** ([Lazy initialization][link-wikipedia-lazyinit]) - приём в программировании, когда некоторая ресурсоёмкая операция (создание объекта, вычисление значения) выполняется непосредственно перед тем, как будет использован её результат. Таким образом, инициализация выполняется «по требованию», а не заблаговременно.

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

``` php
mixed lazyInit( Closure $container, string $key, array $params = [] )
```

- **$container** - Closure-контейнер, содержащий в себе вычисления, должен вернуть результат.
- **$key** - Ключ для сохранения результата вычисления Closure-контейнера, как правило это `__METHOD__`.
- **$params** - Дополнительные данные, которые будут переданы в Closure-контейнер при его запуске.


Простой геттер:
``` php
class Lazy {

    use \iiifx\LazyInit\LazyInitTrait;

    /**
     * @return string
     */
    public function getDate () {
        return $this->lazyInit( function () {
            return date( 'd.m.Y' );
        }, __METHOD__ );
    }

}

$lazy = new Lazy();
echo $lazy->getDate(); # '12.07.2015'
```



Геттер с зависимостью от входящего значения:
``` php
class Lazy {

    use \iiifx\LazyInit\LazyInitTrait;

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

}

$lazy = new Lazy();
var_export( $lazy->parseString( 'A:B:C' ) ); # [ 0 => 'A', 1 => 'B', 2 => 'C' ]
var_export( $lazy->formatTimastamp( time() ) ); # '12.07.2015'
```



Использование в статических методах:
``` php
class LazyStatic {

    use \iiifx\LazyInit\LazyInitStaticTrait;

    /**
     * @return string
     */
    public static function getDate () {
        return self::lazyInitStatic( function () {
            return date( 'd.m.Y' );
        }, __METHOD__ );
    }

}

echo LazyStatic::getDate(); # '12.07.2015'
```



Использование хелпера за пределами классов:
``` php
use iiifx\LazyInit\LazyInitHelper;

function buildString ( $array ) {
    return LazyInitHelper::lazyInit( function ( $v ) {
        return implode( '.', $v );
    }, 'build-string', [ $array ] );
}

echo buildString( [ 1, 5, 32 ] ); # '1.5.32'
```



Использование при создании одиночки([Singleton][link-wikipedia-singleton]):
``` php
class Singleton {

    use \iiifx\LazyInit\LazyInitStaticTrait;

    private function __construct () {}
    private function __clone () {}
    private function __wakeup () {}

    /**
     * @return static
     */
    public static function getInstance () {
        return static::lazyInitStatic( function () {
            return new static();
        }, __METHOD__ );
    }

}
$instance = Singleton::getInstance();
```



Использование при создании пула одиночек([Multiton][link-wikipedia-multiton]):
``` php
class Multiton {

    use \iiifx\LazyInit\LazyInitStaticTrait;

    private function __clone () {}
    private function __wakeup () {}

    public $key;

    protected function __construct ( $key ) {
        $this->key = $key;
    }

    /**
     * @param string $key
     *
     * @return static
     */
    public static function getInstance ( $key ) {
        return static::lazyInitStatic( function ( $key ) {
            return new static( $key );
        }, $key, [ $key ] );
    }

}

echo Multiton::getInstance( 'master' )->key; # 'master'
echo Multiton::getInstance( 'slave' )->key; # 'slave'
echo Multiton::getInstance( 'master' )->key; # 'master'
```

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
[link-wikipedia-lazyinit]: https://ru.wikipedia.org/wiki/%D0%9E%D1%82%D0%BB%D0%BE%D0%B6%D0%B5%D0%BD%D0%BD%D0%B0%D1%8F_%D0%B8%D0%BD%D0%B8%D1%86%D0%B8%D0%B0%D0%BB%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D1%8F
[link-wikipedia-singleton]: https://ru.wikipedia.org/wiki/%D0%9E%D0%B4%D0%B8%D0%BD%D0%BE%D1%87%D0%BA%D0%B0_(%D1%88%D0%B0%D0%B1%D0%BB%D0%BE%D0%BD_%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D1%8F)
[link-wikipedia-multiton]: https://en.wikipedia.org/wiki/Multiton_pattern
