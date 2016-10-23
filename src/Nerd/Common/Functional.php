<?php

namespace Nerd\Common\Functional;

use function Nerd\Common\Arrays\all;
use function Nerd\Common\Arrays\any;

/**
 * Decorates given function with tail recursion optimization.
 *
 * I took solution here https://gist.github.com/beberlei/4145442
 * but reworked it for use without classes.
 *
 * @param callable $fn
 * @return \Closure
 */
function tail(callable $fn)
{
    $underCall = false;
    $pool = [];
    return function (...$args) use (&$fn, &$underCall, &$pool) {
        $result = null;
        $pool[] = $args;
        if (!$underCall) {
            $underCall = true;
            while ($pool) {
                $head = array_shift($pool);
                $result = $fn(...$head);
            }
            $underCall = false;
        }
        return $result;
    };
}

function eq($test)
{
    return function ($actual) use ($test) {
        return is_callable($test) ? $test($actual) : $actual === $test;
    };
}

function not(callable $callable)
{
    return function ($value) use ($callable) {
        return !$callable($value);
    };
}

function opAnd(callable ...$functions)
{
    return function ($value) use ($functions) {
        return all($functions, eq($value));
    };
}

function opOr(callable ...$functions)
{
    return function ($value) use ($functions) {
        return any($functions, eq($value));
    };
}
