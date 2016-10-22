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
