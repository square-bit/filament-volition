<?php

namespace Squarebit\FilamentVolition\Elements;

use Illuminate\Support\Str;
use Squarebit\Volition\Facades\Volition;

trait FilamentAction
{
    use FilamentElement {
        getLabel as getElementLabel;
    }

    public static function registerVolition(): void
    {
        Volition::registerActions(static::class);
    }

    public static function getLabel(): string
    {
        $name = static::getElementLabel();

        return str_ends_with($name, 'Action')
            ? Str::beforeLast($name, 'Action')
            : $name;
    }
}
