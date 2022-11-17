<?php

namespace App\Enums;

use ReflectionClass;

abstract class Enum
{
    /**
     * @return array
     */
    public static function list()
    {
        $class = new ReflectionClass(static::class);

        return collect($class->getConstants())
            ->values()
            ->toArray();
    }
}
