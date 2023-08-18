<?php

namespace Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource;

class EditRule extends EditRecord
{
    protected static string $resource = RuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
