<?php

use iiifx\LazyInit\LazyInitHelper;

class LazyInitHelperTest extends PHPUnit_Framework_TestCase {

    function testInitClosure () {
        $this->assertNull( LazyInitHelper::lazyInit( function () {}, '1' ) );
        $this->assertNull( LazyInitHelper::lazyInit( function () {
            return NULL;
        }, '2' ) );
        $this->assertTrue( LazyInitHelper::lazyInit( function () {
            return TRUE;
        }, '3' ) );
        $this->assertFalse( LazyInitHelper::lazyInit( function () {
            return FALSE;
        }, '4' ) );
    }

    function testClosureParams () {
        $a = 1;
        LazyInitHelper::lazyInit( function ( $b, $c ) use ( $a ) {
            $this->assertEquals( $a, 1 );
            $this->assertEquals( $b, 2 );
            $this->assertEquals( $c, 3 );
        }, '5', [ 2, 3 ] );
    }

    function testResults () {
        $this->assertEquals( LazyInitHelper::lazyInit( function ( $v ) {
            return $v + 10;
        }, '6', [ 1 ] ), 11 );
        $this->assertEquals( LazyInitHelper::lazyInit( function ( $v ) {
            return $v + 100;
        }, '6', [ 1 ] ), 11 );
    }

}