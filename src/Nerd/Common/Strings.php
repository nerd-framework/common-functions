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

function toHeadTail($string)
{
    if (strlen($string) == 0) {
        return [null, null];
    }
    return [$string[0], substr($string, 1)];
}
