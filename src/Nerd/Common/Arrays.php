<?php

namespace Nerd\Common\Arrays;

use function Nerd\Common\Functional\tail;

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

/**
 * Rotate items of given arrays into one array.
 *
 * @example
 *   $arr1 = ['a', 'b', 'c', 'd'];
 *   $arr2 = [1, 2, 3, 4];
 *   $result = rotate($arr1, $arr2); // ['a', 1, 'b', 2, 'c', 3, 'd', 4]
 *
 * @param \array[] ...$arrays
 * @return mixed
 */
function rotate(array ...$arrays)
{
    if (sizeof($arrays) == 0) {
        return [];
    }

    $size = max(array_map('sizeof', $arrays));

    $iter = tail(function ($index, $max, $acc) use (&$iter, &$arrays) {
        if ($index == $max) {
            return $acc;
        }

        $current = array_reduce($arrays, function ($result, $array) use ($index) {
            return append($result, array_key_exists($index, $array) ? $array[$index] : null);
        }, []);

        return $iter($index + 1, $max, array_merge($acc, $current));
    });

    return $iter(0, $size, []);
}

/**
 * Converts array into string.
 *
 * @param array $array
 * @return string
 */
function toString(array $array)
{
    if (empty($array)) {
        return '[]';
    }

    $inner = function ($item) {
        if (is_array($item)) {
            return toString($item);
        }
        if (is_string($item)) {
            return '"' . str_replace('"', "\"", $item) . '"';
        }
        return strval($item);
    };

    list ($head, $tail) = toHeadTail($array);

    $result = array_reduce($tail, function ($acc, $item) use (&$inner) {
        return $acc . ', ' . $inner($item);
    }, $inner($head));

    return '[' . $result . ']';
}
