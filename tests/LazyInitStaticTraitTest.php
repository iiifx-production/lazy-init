<?php

use iiifx\LazyInit\LazyInitStaticTrait;

class LazyInitStaticTraitTest extends PHPUnit_Framework_TestCase
{
    use LazyInitStaticTrait;

    public function setUp()
    {
        static::$lazyInitStaticData = [];
    }

    public function testInitClosure()
    {
        $this->assertNull(static::lazyInitStatic(function () {
        }, '1'));
        $this->assertNull(static::lazyInitStatic(function () {
        }));
        $this->assertNull(static::lazyInitStatic(function () {
            return;
        }, '2'));
        $this->assertTrue(static::lazyInitStatic(function () {
            return true;
        }, '3'));
        $this->assertFalse(static::lazyInitStatic(function () {
            return false;
        }, '4'));
        $this->assertTrue(static::lazyInitStatic(function () {
            return true;
        }));
    }

    public function testClosureParams()
    {
        $a = 1;
        static::lazyInitStatic(function ($b, $c) use ($a) {
            $this->assertEquals($a, 1);
            $this->assertEquals($b, 2);
            $this->assertEquals($c, 3);
        }, '1', [2, 3]);
        $a = 10;
        static::lazyInitStatic(function ($b, $c) use ($a) {
            $this->assertEquals($a, 10);
            $this->assertEquals($b, 20);
            $this->assertEquals($c, 30);
        }, null, [20, 30]);
    }

    public function testCountResults()
    {
        $this->assertEquals(count(static::$lazyInitStaticData), 0);
        static::lazyInitStatic(function () {
        }, '1');
        $this->assertEquals(count(static::$lazyInitStaticData), 1);
        static::lazyInitStatic(function () {
        }, '1');
        $this->assertEquals(count(static::$lazyInitStaticData), 1);
        static::lazyInitStatic(function () {
        }, '2');
        $this->assertEquals(count(static::$lazyInitStaticData), 2);
        static::lazyInitStatic(function () {
        }, '2');
        $this->assertEquals(count(static::$lazyInitStaticData), 2);
        static::lazyInitStatic(function () {
        }, '1');
        $this->assertEquals(count(static::$lazyInitStaticData), 2);
        static::lazyInitStatic(function () {
        }, '3');
        $this->assertEquals(count(static::$lazyInitStaticData), 3);
        static::lazyInitStatic(function () {
        });
        $this->assertEquals(count(static::$lazyInitStaticData), 4);
        static::lazyInitStatic(function () {
        });
        $this->assertEquals(count(static::$lazyInitStaticData), 5);
    }

    public function testResults()
    {
        $this->assertEquals(static::lazyInitStatic(function ($v) {
            return $v + 10;
        }, '1', [1]), 11);
        $this->assertEquals(static::lazyInitStatic(function ($v) {
            return $v + 100;
        }, '1', [1]), 11);
        $this->assertEquals(static::lazyInitStatic(function ($v) {
            return $v + 20;
        }, null, [2]), 22);
        $this->assertEquals(static::lazyInitStatic(function ($v) {
            return $v + 200;
        }, null, [2]), 202);
    }

    public function testBacktraceKey()
    {
        $result = $this->backtraceMethodOne();
        $this->assertEquals($this->backtraceMethodOne(), $result);
        $this->assertEquals($this->backtraceMethodOne(), $result);
        $this->assertEquals($this->backtraceMethodTwo(), $result);
        $this->assertEquals($this->backtraceMethodTwo(), $result);
        $this->assertEquals($this->backtraceMethodThree(), $result);
        $this->assertEquals($this->backtraceMethodThree(), $result);
    }

    public function backtraceMethodOne()
    {
        usleep(1);

        return static::lazyInitStatic(function () {
            return microtime(true);
        });
    }

    public function backtraceMethodTwo()
    {
        return $this->backtraceMethodOne();
    }

    public function backtraceMethodThree()
    {
        return $this->backtraceMethodTwo();
    }
}
