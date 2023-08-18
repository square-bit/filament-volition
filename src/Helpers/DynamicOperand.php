<?php

namespace Squarebit\FilamentVolition\Helpers;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;

class DynamicOperand
{
    public const OPERATIONS = [
        '<',
        '<=',
        '=',
        '!=',
        '<>',
        '>',
        '>=',
    ];

    public static function check(mixed $a, string $operation, mixed $b): bool
    {
        return match ($operation) {
            '<' => $a < $b,
            '<=' => $a <= $b,
            '=' => $a == $b,
            '!=', '<>' => $a != $b,
            '>' => $a > $b,
            '>=' => $a >= $b,
            default => false,
        };
    }

    public function formSchema(): Field
    {
        return Select::make('operation')
            ->options([
                '<' => '<',
                '<=' => '<=',
                '==' => '==',
                '!=' => '!=',
                '<>' => '<>',
                '>' => '>',
                '>=' => '>=',
            ]);
    }
}
