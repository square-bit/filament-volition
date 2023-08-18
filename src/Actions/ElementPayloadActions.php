<?php

namespace Squarebit\FilamentVolition\Actions;

use Squarebit\FilamentVolition\Contracts\IsFilamentElement;

abstract class ElementPayloadActions
{
    public static function mutateFormDataCallable(): callable
    {
        return function (array $data): array {
            /** @var IsFilamentElement $payloadClass */
            $payloadClass = $data['payload'][0]['type'];
            $payloadData = $data['payload'][0]['data'];

            $data['payload'] = $payloadClass::fromFilamentFormData($payloadData);

            return $data;
        };
    }
}
