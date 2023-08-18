<?php

namespace Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource;

class ListRules extends ListRecords
{
    protected static string $resource = RuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
