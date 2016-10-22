<?php

namespace Nerd\Common\Functional;

/**
 * Optimize given function for tail recursion.
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
