<?php

namespace Squarebit\FilamentVolition\Facades;

use Filament\Forms\Components\Builder\Block;
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
 * @method static array<int, Block> getFilamentBlocksForConditions()
 * @method static array<int, Block> getFilamentBlocksForActions()
 */
class FilamentVolition extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Squarebit\FilamentVolition\FilamentVolition::class;
    }
}
