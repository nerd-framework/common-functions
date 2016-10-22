<?php

namespace tests;

use function Nerd\Common\Functional\tail;
use PHPUnit\Framework\TestCase;

class FunctionalTest extends TestCase
{
    public function testTailRecursion()
    {
        $func = tail(function ($max, $acc = 0) use (&$func) {
            if ($max == $acc) {
                return $acc;
            }
            return $func($max, $acc + 1);
        });
        $this->assertEquals(10000, $func(10000));
    }
}
