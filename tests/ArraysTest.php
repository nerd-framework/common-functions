<?php

namespace tests;

use function Nerd\Common\Arrays\arrayOf;
use function Nerd\Common\Arrays\toHeadTail;
use PHPUnit\Framework\TestCase;

use function Nerd\Common\Arrays\all;
use function Nerd\Common\Arrays\any;

use const Nerd\Common\Arrays\TEST_KEY;
use const Nerd\Common\Arrays\TEST_BOTH;

class ArraysTest extends TestCase
{
    public function testAllValue()
    {
        $test = function ($item) {
            return $item > 0;
        };
        $this->assertFalse(all([-10, -5, 0, 10, 20], $test));
        $this->assertTrue(all([10, 15, 20], $test));
        $this->assertTrue(all([], $test));
    }

    public function testAllKey()
    {
        $test = function ($key) {
            return strlen($key) == 2;
        };
        $this->assertFalse(all(["aa" => 15, "abc" => 10], $test, TEST_KEY));
        $this->assertTrue(all(["aa" => 155, "ab" => 10], $test, TEST_KEY));
        $this->assertTrue(all([], $test, TEST_KEY));
    }

    public function testAllBoth()
    {
        $test = function ($value, $key) {
            return strlen($key) == 2 && $value > 0;
        };
        $this->assertFalse(all(["a"  => -10, "b"  => 15, "ab" => 20], $test, TEST_BOTH));
        $this->assertTrue(all(["ab" => 15, "cc" => 20], $test, TEST_BOTH));
        $this->assertTrue(all([], $test, TEST_BOTH));
    }

    public function testAnyValue()
    {
        $test = function ($item) {
            return $item > 0;
        };
        $this->assertTrue(any([-10, -5, 0, 10, 20], $test));
        $this->assertTrue(any([10, 15, 20], $test));
        $this->assertFalse(any([-10, -5, -1], $test));
        $this->assertFalse(any([], $test));
    }

    public function testAnyKey()
    {
        $test = function ($key) {
            return strlen($key) == 2;
        };
        $this->assertTrue(any(["aa" => 15, "abc" => 10], $test, TEST_KEY));
        $this->assertFalse(any(["aaa" => 155, "abc" => 10], $test, TEST_KEY));
        $this->assertFalse(any([], $test, TEST_KEY));
    }

    public function testAnyBoth()
    {
        $test = function ($value, $key) {
            return strlen($key) == 2 && $value > 0;
        };
        $this->assertTrue(any(["a"  => -10, "b"  => 15, "ab" => 20], $test, TEST_BOTH));
        $this->assertTrue(any(["ab" => 15, "cc" => 20], $test, TEST_BOTH));
        $this->assertFalse(any([], $test, TEST_BOTH));
        $this->assertFalse(any(["a" => 15, "ab" => -15], $test, TEST_BOTH));
    }

    public function testArrayOf()
    {
        $this->assertEquals([1, 2, 3], arrayOf(1, 2, 3));
        $this->assertEquals([1], arrayOf(1));
        $this->assertEquals([], arrayOf());
    }

    public function testSplitHeadTail()
    {
        $this->assertEquals([1, [2, 3]], toHeadTail(arrayOf(1, 2, 3)));
        $this->assertEquals([null, []], toHeadTail(arrayOf()));
    }
}
