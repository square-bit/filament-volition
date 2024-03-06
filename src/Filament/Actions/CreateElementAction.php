<?php

namespace Squarebit\FilamentVolition\Filament\Actions;

use Filament\Tables\Actions\CreateAction;

class CreateElementAction extends CreateAction
{
    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->mutateFormDataUsing(ElementPayloadActions::mutateFormDataCallable());
    }
}
