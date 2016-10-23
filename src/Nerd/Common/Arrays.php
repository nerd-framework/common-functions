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

/**
 * Create array from variable list of arguments.
 *
 * @param array ...$items
 * @return array
 */
function arrayOf(...$items)
{
    return $items;
}

/**
 * Split array to head and tail.
 *
 * @param $array
 * @return array
 */
function toHeadTail($array)
{
    if (sizeof($array) == 0) {
        return [null, []];
    }
    return [$array[0], array_slice($array, 1)];
}

/**
 * Return new array with added new item.
 *
 * @param array $array
 * @param $item
 * @return mixed
 */
function append(array $array, $item)
{
    $array[] = $item;
    return $array;
}

/**
 * Flatten array.
 *
 * @param array $array
 * @return mixed
 */
function flatten(array $array)
{
    return array_reduce($array, function ($result, $item) {
        return is_array($item) ? array_merge($result, flatten($item)) : append($result, $item);
    }, []);
}

/**
 * Map multidimensional arrays.
 *
 * @param array $array
 * @param callable $callable
 * @return mixed
 */
function deepMap(array $array, callable $callable)
{
    return array_reduce($array, function ($result, $item) use (&$callable) {
        return append($result, is_array($item) ? deepMap($item, $callable) : $callable($item));
    }, []);
}
