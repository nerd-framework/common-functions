<?php

namespace Nerd\Common\Functional;

use Nerd\Common\Arrays;

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

/**
 * Pass $data through $chain of functions and pass to $finish at the end.
 *
 * @param mixed $data
 * @param callable[] $chain
 * @param callable $finish
 * @return \Closure
 */
function pass($data, array $chain, callable $finish)
{
    $reversed = array_reverse($chain);

    $result = array_reduce($reversed, function (callable $next, callable $fn) {
        return function ($data) use ($next, $fn) {
            return $fn($data, $next);
        };
    }, $finish);

    return $result($data);
}
