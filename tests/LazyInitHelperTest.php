<?php

use iiifx\LazyInit\LazyInitHelper;

require_once __DIR__ . '/class/FailLazyInitHelper.php';

class LazyInitHelperTest extends PHPUnit_Framework_TestCase
{
    public function testBacktraceKeyException ()
    {
        $this->setExpectedException( 'ErrorException' );
        FailLazyInitHelper::createBacktraceKey();
        $this->setExpectedException( 'ErrorException' );
        FailLazyInitHelper::createBacktraceKey( '' );
    }

    public function testBacktraceDataException ()
    {
        $this->setExpectedException( 'ErrorException' );
        FailLazyInitHelper::createBacktraceData( 0 );
        $this->setExpectedException( 'ErrorException' );
        FailLazyInitHelper::createBacktraceData( '' );
        $this->setExpectedException( 'ErrorException' );
        FailLazyInitHelper::createBacktraceData( 999 );
    }

    public function testDependencyKey ()
    {
        $this->setExpectedException( 'PHPUnit_Framework_Error' );
        FailLazyInitHelper::createDependencyKey( '' );
    }

    public function testInitClosure ()
    {
        $this->assertNull( LazyInitHelper::lazyInit( function () {
        }, '1' ) );
        $this->assertNull( LazyInitHelper::lazyInit( function () {
            return;
        }, '2' ) );
        $this->assertTrue( LazyInitHelper::lazyInit( function () {
            return true;
        }, '3' ) );
        $this->assertFalse( LazyInitHelper::lazyInit( function () {
            return false;
        }, '4' ) );
        $this->assertTrue( LazyInitHelper::lazyInit( function () {
            return true;
        } ) );
    }

    public function testClosureParams ()
    {
        $a = 1;
        LazyInitHelper::lazyInit( function ( $b, $c ) use ( $a ) {
            $this->assertEquals( $a, 1 );
            $this->assertEquals( $b, 2 );
            $this->assertEquals( $c, 3 );
        }, '5', [ 2, 3 ] );
        $a = 10;
        LazyInitHelper::lazyInit( function ( $b, $c ) use ( $a ) {
            $this->assertEquals( $a, 10 );
            $this->assertEquals( $b, 20 );
            $this->assertEquals( $c, 30 );
        }, null, [ 20, 30 ] );
    }

    public function testResults ()
    {
        $this->assertEquals( LazyInitHelper::lazyInit( function ( $v ) {
            return $v + 10;
        }, '6', [ 1 ] ), 11 );
        $this->assertEquals( LazyInitHelper::lazyInit( function ( $v ) {
            return $v + 100;
        }, '6', [ 1 ] ), 11 );
        $this->assertEquals( LazyInitHelper::lazyInit( function ( $v ) {
            return $v + 20;
        }, null, [ 2 ] ), 22 );
        $this->assertEquals( LazyInitHelper::lazyInit( function ( $v ) {
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

        return LazyInitHelper::lazyInit( function () {
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
