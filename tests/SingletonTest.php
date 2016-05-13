<?php

use iiifx\LazyInit\LazyInitStaticTrait;

class SingletonTest extends PHPUnit_Framework_TestCase
{
    use LazyInitStaticTrait;

    public function testSingleton ()
    {
        $this->assertEquals( LazyInitStaticTraitTest_Singleton::getInstance( 'key' )->key, 'key' );
        $this->assertEquals( LazyInitStaticTraitTest_Singleton::getInstance( 'key' )->key, 'key' );
        $this->assertEquals( LazyInitStaticTraitTest_Singleton::getInstance( 'wrong-key' )->key, 'key' );
        $this->assertEquals( LazyInitStaticTraitTest_Singleton::getInstance( 'key' )->key, 'key' );
    }
}

/**
 * Class LazyInitStaticTraitTest_Singleton.
 *
 * Для теста
 */
class LazyInitStaticTraitTest_Singleton
{
    use LazyInitStaticTrait;

    private function __clone ()
    {
    }

    private function __wakeup ()
    {
    }

    public $key;

    private function __construct ( $key )
    {
        $this->key = $key;
    }

    /**
     * @param $key
     *
     * @return static
     */
    public static function getInstance ( $key )
    {
        return static::lazyInitStatic( function ( $key ) {
            return new static( $key );
        }, __METHOD__, [ $key ] );
    }
}
