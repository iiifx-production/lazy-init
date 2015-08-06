<?php

use iiifx\LazyInit\LazyInitHelper;

class LazyInitHelperTest extends PHPUnit_Framework_TestCase
{
    function testInitClosure ()
    {
        $this->assertNull( LazyInitHelper::lazyInit( function () {
        }, '1' ) );
        $this->assertNull( LazyInitHelper::lazyInit( function () {
            return NULL;
        }, '2' ) );
        $this->assertTrue( LazyInitHelper::lazyInit( function () {
            return TRUE;
        }, '3' ) );
        $this->assertFalse( LazyInitHelper::lazyInit( function () {
            return FALSE;
        }, '4' ) );
        $this->assertTrue( LazyInitHelper::lazyInit( function () {
            return TRUE;
        } ) );
    }

    function testClosureParams ()
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
        }, NULL, [ 20, 30 ] );
    }

    function testResults ()
    {
        $this->assertEquals( LazyInitHelper::lazyInit( function ( $v ) {
            return $v + 10;
        }, '6', [ 1 ] ), 11 );
        $this->assertEquals( LazyInitHelper::lazyInit( function ( $v ) {
            return $v + 100;
        }, '6', [ 1 ] ), 11 );
        $this->assertEquals( LazyInitHelper::lazyInit( function ( $v ) {
            return $v + 20;
        }, NULL, [ 2 ] ), 22 );
        $this->assertEquals( LazyInitHelper::lazyInit( function ( $v ) {
            return $v + 200;
        }, NULL, [ 2 ] ), 202 );
    }

    function testBacktraceKey ()
    {
        $result = $this->backtraceMethodOne();
        $this->assertEquals( $this->backtraceMethodOne(), $result );
        $this->assertEquals( $this->backtraceMethodOne(), $result );
        $this->assertEquals( $this->backtraceMethodTwo(), $result );
        $this->assertEquals( $this->backtraceMethodTwo(), $result );
        $this->assertEquals( $this->backtraceMethodThree(), $result );
        $this->assertEquals( $this->backtraceMethodThree(), $result );
    }

    function backtraceMethodOne ()
    {
        usleep( 1 );
        return LazyInitHelper::lazyInit( function () {
            return microtime( TRUE );
        } );
    }

    function backtraceMethodTwo ()
    {
        return $this->backtraceMethodOne();
    }

    function backtraceMethodThree ()
    {
        return $this->backtraceMethodTwo();
    }
}