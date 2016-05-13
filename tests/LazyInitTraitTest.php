<?php

use iiifx\LazyInit\LazyInitTrait;

class LazyInitTraitTest extends PHPUnit_Framework_TestCase
{
    use LazyInitTrait;

    public function testInitClosure ()
    {
        $this->assertNull( $this->lazyInit( function () {
        }, '1' ) );
        $this->assertNull( $this->lazyInit( function () {
            return;
        }, '2' ) );
        $this->assertTrue( $this->lazyInit( function () {
            return true;
        }, '3' ) );
        $this->assertFalse( $this->lazyInit( function () {
            return false;
        }, '4' ) );
        $this->assertEquals( $this->lazyInit( function () {
            return 99;
        } ), 99 );
    }

    public function testClosureParams ()
    {
        $a = 1;
        $this->lazyInit( function ( $b, $c ) use ( $a ) {
            $this->assertEquals( $a, 1 );
            $this->assertEquals( $b, 2 );
            $this->assertEquals( $c, 3 );
        }, '1', [ 2, 3 ] );
        $a = 10;
        $this->lazyInit( function ( $b, $c ) use ( $a ) {
            $this->assertEquals( $a, 10 );
            $this->assertEquals( $b, 20 );
            $this->assertEquals( $c, 30 );
        }, null, [ 20, 30 ] );
    }

    public function testCountResults ()
    {
        $this->assertEquals( count( $this->lazyInitData ), 0 );
        $this->lazyInit( function () {
        }, '1' );
        $this->assertEquals( count( $this->lazyInitData ), 1 );
        $this->lazyInit( function () {
        }, '1' );
        $this->assertEquals( count( $this->lazyInitData ), 1 );
        $this->lazyInit( function () {
        }, '2' );
        $this->assertEquals( count( $this->lazyInitData ), 2 );
        $this->lazyInit( function () {
        }, '2' );
        $this->assertEquals( count( $this->lazyInitData ), 2 );
        $this->lazyInit( function () {
        }, '1' );
        $this->assertEquals( count( $this->lazyInitData ), 2 );
        $this->lazyInit( function () {
        }, '3' );
        $this->assertEquals( count( $this->lazyInitData ), 3 );
        $this->lazyInit( function () {
        } );
        $this->assertEquals( count( $this->lazyInitData ), 4 );
        $this->lazyInit( function () {
        } );
        $this->assertEquals( count( $this->lazyInitData ), 5 );
    }

    public function testResults ()
    {
        $this->assertEquals( $this->lazyInit( function ( $v ) {
            return $v + 10;
        }, '1', [ 1 ] ), 11 );
        $this->assertEquals( $this->lazyInit( function ( $v ) {
            return $v + 100;
        }, '1', [ 1 ] ), 11 );
        $this->assertEquals( $this->lazyInit( function ( $v ) {
            return $v + 20;
        }, null, [ 2 ] ), 22 );
        $this->assertEquals( $this->lazyInit( function ( $v ) {
            return $v + 200;
        }, null, [ 2 ] ), 202 );
    }

    public function testBacktraceKey ()
    {
        $result = $this->backtraceMethodOne();
        $this->assertEquals( $this->backtraceMethodOne(), $result );
        $this->assertEquals( $this->backtraceMethodOne(), $result );
        $this->assertEquals( $this->backtraceMethodTwo(), $result );
        $this->assertEquals( $this->backtraceMethodTwo(), $result );
        $this->assertEquals( $this->backtraceMethodThree(), $result );
        $this->assertEquals( $this->backtraceMethodThree(), $result );
    }

    public function backtraceMethodOne ()
    {
        usleep( 1 );

        return $this->lazyInit( function () {
            return microtime( true );
        } );
    }

    public function backtraceMethodTwo ()
    {
        return $this->backtraceMethodOne();
    }

    public function backtraceMethodThree ()
    {
        return $this->backtraceMethodTwo();
    }
}
