# LazyInit

LazyInit - хелпер для быстрого создания методов ленивой(отложенной) инициализации.

[![Latest Version on Packagist][ico-version]][link-packagist] [![Build Status][ico-travis]][link-travis] [![Software License][ico-license]](LICENSE.md) [![Total Downloads][ico-downloads]][link-downloads]

Отложенная (ленивая) инициализация (Lazy initialization) - приём в программировании, когда некоторая ресурсоёмкая операция (создание объекта, вычисление значения) выполняется непосредственно перед тем, как будет использован её результат. Таким образом, инициализация выполняется «по требованию», а не заблаговременно.

Классический пример использования:
``` php
class LazyValue {

    protected $value;

    public function getValue () {
        if ( is_null( $this->value ) ) {
            $this->value = 42;
        }
        return $this->value;
    }

}

$lazyValue = new LazyValue();
echo $lazyValue->getValue(); # 42
``` 

Аналогичный пример, но с использованием LazyInit:
``` php
class LazyValue {

    use \iiifx\LazyInit\LazyInitTrait;

    public function getValue () {
        return $this->lazyInit( function () {
            return 42;
        }, __METHOD__ );
    }

}

$lazyValue = new LazyValue();
echo $lazyValue->getValue(); # 42
``` 

## Установка

Используя Composer:

``` bash
$ composer require "iiifx-production/lazy-init:0.2.*"
```

## Использование

@TODO

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

.
