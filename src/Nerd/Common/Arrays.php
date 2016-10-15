<?php

namespace Nerd\Common\Arrays;

const TEST_VALUE = 0;
const TEST_KEY   = 1;
const TEST_BOTH  = 2;

/**
 * Tests whether some element in the array passes the test
 * implemented by the provided function.
 *
 * @param $array
 * @param $callable
 * @param int $option
 * @return bool
 */
function any($array, $callable, $option = TEST_VALUE)
{
    foreach ($array as $key => $value) {
        switch ($option) {
            case TEST_KEY:
                $test = $callable($key);
                break;
            case TEST_BOTH:
                $test = $callable($value, $key);
                break;
            case TEST_VALUE:
            default:
                $test = $callable($value);
        }
        if ($test) {
            return true;
        }
    }
    return false;
}

/**
 * Tests whether all elements in the array pass the test
 * implemented by the provided function.
 *
 * @param $array
 * @param $callable
 * @param int $option
 * @return bool
 */
function all($array, $callable, $option = TEST_VALUE)
{
    foreach ($array as $key => $value) {
        switch ($option) {
            case TEST_KEY:
                $test = $callable($key);
                break;
            case TEST_BOTH:
                $test = $callable($value, $key);
                break;
            case TEST_VALUE:
            default:
                $test = $callable($value);
        }
        if (!$test) {
            return false;
        }
    }
    return true;
}
