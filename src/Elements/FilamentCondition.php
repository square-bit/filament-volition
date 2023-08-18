<?php

namespace Squarebit\FilamentVolition\Elements;

use Illuminate\Support\Str;
use Squarebit\Volition\Facades\Volition;

trait FilamentCondition
{
    use FilamentElement {
        getLabel as getElementLabel;
    }

    public static function registerVolition(): void
    {
        Volition::registerConditions(static::class);
    }

    public static function getLabel(): string
    {
        $name = static::getElementLabel();

        return str_ends_with($name, 'Condition')
            ? Str::beforeLast($name, 'Condition')
            : $name;
    }
}
