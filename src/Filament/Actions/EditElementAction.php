<?php

namespace Squarebit\FilamentVolition\Filament\Actions;

use Filament\Tables\Actions\EditAction;

class EditElementAction extends EditAction
{
    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->mutateFormDataUsing(ElementPayloadActions::mutateFormDataCallable())
            ->mutateRecordDataUsing(ElementPayloadActions::mutateRecordDataCallable());
    }
}
