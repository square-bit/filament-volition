<?php

namespace Squarebit\FilamentVolition\Actions;

use Filament\Tables\Actions\EditAction;

class EditElementAction extends EditAction
{
    public static function make(string $name = null): static
    {
        return parent::make($name)
            ->mutateFormDataUsing(ElementPayloadActions::mutateFormDataCallable())
            ->mutateRecordDataUsing(function (array $data): array {
                $data['payload'] = $data['payload']->toFilamentFormData();

                return $data;
            });
    }
}
