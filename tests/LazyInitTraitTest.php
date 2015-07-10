<?php

use iiifx\LazyInit\LazyInitTrait;

class LazyInitTraitTest extends PHPUnit_Framework_TestCase {

    use LazyInitTrait;

    function testInitNoClosure () {
        $this->setExpectedException( 'InvalidArgumentException' );
        /** @noinspection PhpParamsInspection */
        $this->lazyInit( '', '' );
    }

    function testInitClosure () {
        $this->assertNull( $this->lazyInit( function () {}, '1' ) );
        $this->assertNull( $this->lazyInit( function () {
            return NULL;
        }, '2' ) );
        $this->assertTrue( $this->lazyInit( function () {
            return TRUE;
        }, '3' ) );
        $this->assertFalse( $this->lazyInit( function () {
            return FALSE;
        }, '4' ) );
    }

    function testClosureParams () {
        $a = 1;
        $this->lazyInit( function ( $b, $c ) use ( $a ) {
            $this->assertEquals( $a, 1 );
            $this->assertEquals( $b, 2 );
            $this->assertEquals( $c, 3 );
        }, '1', [ 2, 3 ] );
    }

    function testCountResults () {
        $this->assertEquals( count( $this->lazyInitData ), 0 );
        $this->lazyInit( function () {}, '1' );
        $this->assertEquals( count( $this->lazyInitData ), 1 );
        $this->lazyInit( function () {}, '1' );
        $this->assertEquals( count( $this->lazyInitData ), 1 );
        $this->lazyInit( function () {}, '2' );
        $this->assertEquals( count( $this->lazyInitData ), 2 );
        $this->lazyInit( function () {}, '2' );
        $this->assertEquals( count( $this->lazyInitData ), 2 );
        $this->lazyInit( function () {}, '1' );
        $this->assertEquals( count( $this->lazyInitData ), 2 );
        $this->lazyInit( function () {}, '3' );
        $this->assertEquals( count( $this->lazyInitData ), 3 );
    }

    function testResults () {
        $this->assertEquals( $this->lazyInit( function ( $v ) {
            return $v + 10;
        }, '1', [ 1 ] ), 11 );
        $this->assertEquals( $this->lazyInit( function ( $v ) {
            return $v + 100;
        }, '1', [ 1 ] ), 11 );
    }

}
