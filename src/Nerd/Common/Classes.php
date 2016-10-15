<?php

namespace Nerd\Common\Classes;

/**
 * Get array of subclasses for given class leading with self.
 *
 * @param $class
 * @return mixed
 */
function subclassesOf($class)
{
    $ref = new \ReflectionClass($class);
    $iter = function ($ref, $acc) use (&$iter) {
        if (!$ref) {
            return $acc;
        }
        $acc[] = $ref->getName();
        return $iter($ref->getParentClass(), array_merge($acc));
    };
    return $iter($ref, []);
}
