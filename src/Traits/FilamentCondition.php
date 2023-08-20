<?php

namespace Squarebit\FilamentVolition\Traits;

use Illuminate\Support\Str;

trait FilamentCondition
{
    use FilamentElement {
        getLabel as getElementLabel;
    }

    public static function getLabel(): string
    {
        $name = static::getElementLabel();

        return str_ends_with($name, 'Condition')
            ? Str::beforeLast($name, 'Condition')
            : $name;
    }
}
