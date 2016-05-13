<?php

use iiifx\LazyInit\LazyInitStaticTrait;

class MultitonTest extends PHPUnit_Framework_TestCase
{
    use LazyInitStaticTrait;

    public function testMultiton ()
    {
        $this->assertEquals( LazyInitStaticTraitTest_Multiton::getInstance( 'key-1' )->key, 'key-1' );
        $this->assertEquals( LazyInitStaticTraitTest_Multiton::getInstance( 'key-1' )->key, 'key-1' );
        $this->assertEquals( LazyInitStaticTraitTest_Multiton::getInstance( 'key-2' )->key, 'key-2' );
        $this->assertEquals( LazyInitStaticTraitTest_Multiton::getInstance( 'key-1' )->key, 'key-1' );
    }
}

/**
 * Class LazyInitStaticTraitTest_Multiton.
 *
 * Для теста
 */
class LazyInitStaticTraitTest_Multiton
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
        }, $key, [ $key ] );
    }
}
