<?php

namespace Squarebit\FilamentVolition\Traits;

use Illuminate\Support\Str;

trait FilamentAction
{
    use FilamentElement {
        getLabel as getElementLabel;
    }

    public static function getLabel(): string
    {
        $name = static::getElementLabel();

        return str_ends_with($name, 'Action')
            ? Str::beforeLast($name, 'Action')
            : $name;
    }
}
