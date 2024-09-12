<?php

namespace Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers;

use Filament\Forms\Components\Builder\Block;
use Illuminate\Database\Eloquent\Model;
use Squarebit\FilamentVolition\Facades\FilamentVolition;
use Squarebit\Volition\Models\Rule;

class ConditionsRelationManager extends ElementsRelationManager
{
    protected static string $relationship = 'conditions';

    protected function getBlocks(): array
    {
        return FilamentVolition::getFilamentBlocksForConditions();
    }
    /**
     * @param  Rule  $ownerRecord
     */
    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return (string) $ownerRecord->conditions->count();
    }
}
