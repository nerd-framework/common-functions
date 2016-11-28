<?php

namespace tests;

use function Nerd\Common\Functional\pass;
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

    public function testPass()
    {
        $result = pass('foo', [
            function ($x, $next) {
                return $next($x . '.1');
            },
            function ($x, $next) {
                return $next($x . '.2');
            }
        ], function ($x) {
            return $x . '.end';
        });

        $this->assertEquals('foo.1.2.end', $result);
    }
}
