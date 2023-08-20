<?php

namespace Squarebit\FilamentVolition\Filament\Actions;

use Closure;
use Squarebit\FilamentVolition\Contracts\IsFilamentElement;

class ElementPayloadActions
{
    public static function mutateFormDataCallable(): Closure
    {
        return function (array $data): array {
            /** @var IsFilamentElement $payloadClass */
            $payloadClass = $data['payload'][0]['type'];
            $payloadData = $data['payload'][0]['data'];

            $data['payload'] = $payloadClass::fromFilamentFormData($payloadData);

            return $data;
        };
    }

    public static function mutateRecordDataCallable(): Closure
    {
        return function (array $data): array {
            $data['payload'] = $data['payload']->toFilamentFormData();

            return $data;
        };
    }
}
