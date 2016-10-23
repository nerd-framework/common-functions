<?php

namespace tests;

use Nerd\Common\Arrays;
use PHPUnit\Framework\TestCase;

use const Nerd\Common\Arrays\TEST_KEY;
use const Nerd\Common\Arrays\TEST_BOTH;

class ArraysTest extends TestCase
{
    public function testAllValue()
    {
        $test = function ($item) {
            return $item > 0;
        };
        $this->assertFalse(Arrays\all([-10, -5, 0, 10, 20], $test));
        $this->assertTrue(Arrays\all([10, 15, 20], $test));
        $this->assertTrue(Arrays\all([], $test));
    }

    public function testAllKey()
    {
        $test = function ($key) {
            return strlen($key) == 2;
        };
        $this->assertFalse(Arrays\all(["aa" => 15, "abc" => 10], $test, TEST_KEY));
        $this->assertTrue(Arrays\all(["aa" => 155, "ab" => 10], $test, TEST_KEY));
        $this->assertTrue(Arrays\all([], $test, TEST_KEY));
    }

    public function testAllBoth()
    {
        $test = function ($value, $key) {
            return strlen($key) == 2 && $value > 0;
        };
        $this->assertFalse(Arrays\all(["a"  => -10, "b"  => 15, "ab" => 20], $test, TEST_BOTH));
        $this->assertTrue(Arrays\all(["ab" => 15, "cc" => 20], $test, TEST_BOTH));
        $this->assertTrue(Arrays\all([], $test, TEST_BOTH));
    }

    public function testAnyValue()
    {
        $test = function ($item) {
            return $item > 0;
        };
        $this->assertTrue(Arrays\any([-10, -5, 0, 10, 20], $test));
        $this->assertTrue(Arrays\any([10, 15, 20], $test));
        $this->assertFalse(Arrays\any([-10, -5, -1], $test));
        $this->assertFalse(Arrays\any([], $test));
    }

    public function testAnyKey()
    {
        $test = function ($key) {
            return strlen($key) == 2;
        };
        $this->assertTrue(Arrays\any(["aa" => 15, "abc" => 10], $test, TEST_KEY));
        $this->assertFalse(Arrays\any(["aaa" => 155, "abc" => 10], $test, TEST_KEY));
        $this->assertFalse(Arrays\any([], $test, TEST_KEY));
    }

    public function testAnyBoth()
    {
        $test = function ($value, $key) {
            return strlen($key) == 2 && $value > 0;
        };
        $this->assertTrue(Arrays\any(["a"  => -10, "b"  => 15, "ab" => 20], $test, TEST_BOTH));
        $this->assertTrue(Arrays\any(["ab" => 15, "cc" => 20], $test, TEST_BOTH));
        $this->assertFalse(Arrays\any([], $test, TEST_BOTH));
        $this->assertFalse(Arrays\any(["a" => 15, "ab" => -15], $test, TEST_BOTH));
    }

    public function testArrayOf()
    {
        $this->assertEquals([1, 2, 3], Arrays\arrayOf(1, 2, 3));
        $this->assertEquals([1], Arrays\arrayOf(1));
        $this->assertEquals([], Arrays\arrayOf());
    }

    public function testSplitHeadTail()
    {
        $this->assertEquals([1, [2, 3]], Arrays\toHeadTail(Arrays\arrayOf(1, 2, 3)));
        $this->assertEquals([null, []], Arrays\toHeadTail(Arrays\arrayOf()));
    }

    public function testAppend()
    {
        $source = [1, 2, 3];
        $target = Arrays\append($source, 4);
        $this->assertEquals([1, 2, 3, 4], $target);
        $this->assertNotSame($source, $target);
    }

    public function testFlatten()
    {
        $source = [1, [2, 3, 4], [5], [[6], 7], 8, [[9]]];
        $expected = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $this->assertEquals($expected, Arrays\flatten($source));
    }

    public function testDeepMap()
    {
        $source = [1, [2, 3, 4], [5], [[6], 7], 8, [[9]]];
        $func = function ($item) {
            return $item * 2;
        };
        $expected = [2, [4, 6, 8], [10], [[12], 14], 16, [[18]]];
        $this->assertEquals($expected, Arrays\deepMap($source, $func));
    }
}
