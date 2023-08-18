<?php

namespace Squarebit\FilamentVolition\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Squarebit\FilamentVolition\FilamentVolition
 *
 * @method static self registerVolitionals(array|string $volitionals)
 * @method static self registerConditions(array|string $condition)
 * @method static self registerActions(array|string $action)
 * @method static array volitionals()
 * @method static array conditions()
 * @method static array actions()
 * @method static array getFilamentBlocksForConditions()
 * @method static array getFilamentBlocksForActions()
 */
class FilamentVolition extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Squarebit\FilamentVolition\FilamentVolition::class;
    }
}
