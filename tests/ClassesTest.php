<?php

namespace tests;

use PHPUnit\Framework\TestCase;

use function Nerd\Common\Classes\subclassesOf;

class ClassesTest extends TestCase
{
    public function testSubclassesOf()
    {
        $this->assertEquals(
            [
                self::class,
                TestCase::class,
                \PHPUnit_Framework_TestCase::class,
                \PHPUnit_Framework_Assert::class
            ],
            subclassesOf(self::class)
        );
    }
}
