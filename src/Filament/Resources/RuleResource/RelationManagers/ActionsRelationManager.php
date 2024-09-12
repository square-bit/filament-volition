<?php

namespace Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers;

use Illuminate\Database\Eloquent\Model;
use Squarebit\FilamentVolition\Facades\FilamentVolition;
use Squarebit\Volition\Models\Rule;

class ActionsRelationManager extends ElementsRelationManager
{
    protected static string $relationship = 'actions';

    protected function getBlocks(): array
    {
        return FilamentVolition::getFilamentBlocksForActions();
    }

    /**
     * @param  Rule  $ownerRecord
     */
    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return (string) $ownerRecord->actions->count();
    }
}
