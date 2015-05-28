<?php

require_once __DIR__ . '/../source/LazyInitTrait.php';
require_once __DIR__ . '/../source/LazyInitStaticTrait.php';
require_once __DIR__ . '/../source/LazyInitHelper.php';

use iiifx\LazyInit\LazyInitHelper;
use iiifx\LazyInit\LazyInitStaticTrait;
use iiifx\LazyInit\LazyInitTrait;

class SomeClass {

    use LazyInitTrait;
    use LazyInitStaticTrait;

    /**
     * @return mixed
     */
    public function lazyMethod () {
        echo PHP_EOL . '[Вызван ' . __METHOD__ . '] ';
        return $this->lazyInit( function () {
            echo '[Выполнение 1] ';
            return '{Результат 1} ';
        }, __METHOD__ );
    }

    /**
     * @return mixed
     */
    public static function lazyStaticMethod () {
        echo PHP_EOL . '[Вызван ' . __METHOD__ . '] ';
        return self::lazyInitStatic( function () {
            echo '[Выполнение 2] ';
            return '{Результат 2} ';
        }, __METHOD__ );
    }


    /**
     * @return mixed
     */
    public function lazyMethodWithHelper () {
        echo PHP_EOL . '[Вызван ' . __METHOD__ . '] ';
        return LazyInitHelper::lazyInit( function () {
            echo '[Выполнение 3] ';
            return '{Результат 3} ';
        }, __METHOD__ );
    }

}



$object = new SomeClass();

echo '<pre>';

/**
 * Использование в методе объекта
 */
echo $object->lazyMethod(); // [Вызван SomeClass::lazyMethod] [Выполнение 1] {Результат 1}
echo $object->lazyMethod(); // [Вызван SomeClass::lazyMethod] {Результат 1}
echo $object->lazyMethod(); // [Вызван SomeClass::lazyMethod] {Результат 1}
echo $object->lazyMethod(); // [Вызван SomeClass::lazyMethod] {Результат 1}
echo $object->lazyMethod(); // [Вызван SomeClass::lazyMethod] {Результат 1}

/**
 * Использование в статическом методе класса
 */
echo SomeClass::lazyStaticMethod(); // [Вызван SomeClass::lazyStaticMethod] [Выполнение 2] {Результат 2}
echo SomeClass::lazyStaticMethod(); // [Вызван SomeClass::lazyStaticMethod] {Результат 2}
echo SomeClass::lazyStaticMethod(); // [Вызван SomeClass::lazyStaticMethod] {Результат 2}
echo SomeClass::lazyStaticMethod(); // [Вызван SomeClass::lazyStaticMethod] {Результат 2}
echo SomeClass::lazyStaticMethod(); // [Вызван SomeClass::lazyStaticMethod] {Результат 2}

/**
 * Использование хелпера в методе объекта
 */
echo $object->lazyMethodWithHelper(); // [Вызван SomeClass::lazyMethodWithHelper] [Выполнение 3] {Результат 3}
echo $object->lazyMethodWithHelper(); // [Вызван SomeClass::lazyMethodWithHelper] {Результат 3}
echo $object->lazyMethodWithHelper(); // [Вызван SomeClass::lazyMethodWithHelper] {Результат 3}
echo $object->lazyMethodWithHelper(); // [Вызван SomeClass::lazyMethodWithHelper] {Результат 3}
echo $object->lazyMethodWithHelper(); // [Вызван SomeClass::lazyMethodWithHelper] {Результат 3}

/**
 * Прямое использование хелпера
 */
$closure = function () {
    echo '[Выполнение 4] ';
    return '{Результат 4} ';
};
echo PHP_EOL . '[Вызван LazyInitHelper::lazyInit()] ';
echo LazyInitHelper::lazyInit( $closure, 'helper-request' ); // [Выполнение 4] {Результат 4}
echo PHP_EOL . '[Вызван LazyInitHelper::lazyInit()] ';
echo LazyInitHelper::lazyInit( $closure, 'helper-request' ); // {Результат 4}
echo PHP_EOL . '[Вызван LazyInitHelper::lazyInit()] ';
echo LazyInitHelper::lazyInit( $closure, 'helper-request' ); // {Результат 4}
echo PHP_EOL . '[Вызван LazyInitHelper::lazyInit()] ';
echo LazyInitHelper::lazyInit( $closure, 'helper-request' ); // {Результат 4}
echo PHP_EOL . '[Вызван LazyInitHelper::lazyInit()] ';
echo LazyInitHelper::lazyInit( $closure, 'helper-request' ); // {Результат 4}
