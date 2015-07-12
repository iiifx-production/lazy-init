<?php

use iiifx\LazyInit\LazyInitStaticTrait;

class LazyInitStaticTraitTest extends PHPUnit_Framework_TestCase {

    use LazyInitStaticTrait;

    function setUp () {
        static::$lazyInitStaticData = [];
    }

    function testInitClosure () {
        $this->assertNull( static::lazyInitStatic( function () {}, '1' ) );
        $this->assertNull( static::lazyInitStatic( function () {
            return NULL;
        }, '2' ) );
        $this->assertTrue( static::lazyInitStatic( function () {
            return TRUE;
        }, '3' ) );
        $this->assertFalse( static::lazyInitStatic( function () {
            return FALSE;
        }, '4' ) );
    }

    function testClosureParams () {
        $a = 1;
        static::lazyInitStatic( function ( $b, $c ) use ( $a ) {
            $this->assertEquals( $a, 1 );
            $this->assertEquals( $b, 2 );
            $this->assertEquals( $c, 3 );
        }, '1', [ 2, 3 ] );
    }

    function testCountResults () {
        $this->assertEquals( count( static::$lazyInitStaticData ), 0 );
        static::lazyInitStatic( function () {}, '1' );
        $this->assertEquals( count( static::$lazyInitStaticData ), 1 );
        static::lazyInitStatic( function () {}, '1' );
        $this->assertEquals( count( static::$lazyInitStaticData ), 1 );
        static::lazyInitStatic( function () {}, '2' );
        $this->assertEquals( count( static::$lazyInitStaticData ), 2 );
        static::lazyInitStatic( function () {}, '2' );
        $this->assertEquals( count( static::$lazyInitStaticData ), 2 );
        static::lazyInitStatic( function () {}, '1' );
        $this->assertEquals( count( static::$lazyInitStaticData ), 2 );
        static::lazyInitStatic( function () {}, '3' );
        $this->assertEquals( count( static::$lazyInitStaticData ), 3 );
    }

    function testResults () {
        $this->assertEquals( static::lazyInitStatic( function ( $v ) {
            return $v + 10;
        }, '1', [ 1 ] ), 11 );
        $this->assertEquals( static::lazyInitStatic( function ( $v ) {
            return $v + 100;
        }, '1', [ 1 ] ), 11 );
    }

}