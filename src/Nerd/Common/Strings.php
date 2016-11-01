<?php

namespace Nerd\Common\Strings;

/**
 * @param int $length
 * @param string $text
 * @return string
 */
function indent($length, $text)
{
    $text = explode(PHP_EOL, $text);
    $result = array_map(function ($line) use ($length) {
        return empty($line) ? $line : str_repeat(' ', $length) . $line;
    }, $text);
    return implode(PHP_EOL, $result);
}

/**
 * @param string $text
 * @return array
 */
function toArray($text)
{
    if (strlen($text) == 0) {
        return [];
    }
    return str_split($text, 1);
}

/**
 * @param mixed $value
 * @return string
 */
function toString($value)
{
    if (is_null($value)) {
        return 'NULL';
    }
    if (is_bool($value)) {
        return $value ? 'TRUE' : 'FALSE';
    }
    if (is_scalar($value)) {
        return $value;
    }
    if (is_array($value)) {
        return \Nerd\Common\Arrays\toString($value);
    }
    if (is_object($value) && method_exists($value, '__toString')) {
        return strval($value);
    }
    return get_class($value);
}
