<?php

namespace Nerd\Common\Arrays;

const USE_VALUE = 0;
const USE_KEY = 1;
const USE_BOTH = 2;

/**
 * Test items in array using $callable and return true
 * if at least one of tests successful.
 *
 * @param $array
 * @param $callable
 * @param int $option
 * @return bool
 */
function some($array, $callable, $option = USE_VALUE)
{
    foreach ($array as $key => $value) {
        switch ($option) {
            case USE_KEY:
                $test = $callable($key);
                break;
            case USE_BOTH:
                $test = $callable($value, $key);
                break;
            case USE_VALUE:
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
 * Test items in array using $callable and return true
 * if all tests successful.
 *
 * @param $array
 * @param $callable
 * @param int $option
 * @return bool
 */
function any($array, $callable, $option = USE_VALUE)
{
    foreach ($array as $key => $value) {
        switch ($option) {
            case USE_KEY:
                $test = $callable($key);
                break;
            case USE_BOTH:
                $test = $callable($value, $key);
                break;
            case USE_VALUE:
            default:
                $test = $callable($value);
        }
        if (!$test) {
            return false;
        }
    }
    return true;
}
