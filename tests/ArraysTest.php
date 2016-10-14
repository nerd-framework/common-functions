<?php

namespace tests;

use PHPUnit\Framework\TestCase;

use function Nerd\Common\Arrays\any;
use function Nerd\Common\Arrays\some;

class ArraysTest extends TestCase
{
    public function testAnyValue()
    {
        $test = function ($item) {
            return $item > 0;
        };
        $this->assertFalse(any([-10, -5, 0, 10, 20], $test));
        $this->assertTrue(any([10, 15, 20], $test));
        $this->assertTrue(any([], $test));
    }

    public function testSomeValue()
    {
        $test = function ($item) {
            return $item > 0;
        };
        $this->assertTrue(some([-10, -5, 0, 10, 20], $test));
        $this->assertTrue(some([10, 15, 20], $test));
        $this->assertFalse(some([-10, -5, -1], $test));
        $this->assertFalse(some([], $test));
    }
}
