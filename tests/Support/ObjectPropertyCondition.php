<?php

namespace Squarebit\FilamentVolition\Tests\Support;

use Filament\Forms\Components\TextInput;
use Squarebit\FilamentVolition\Contracts\IsFilamentCondition;
use Squarebit\FilamentVolition\Traits\FilamentCondition;
use Squarebit\Volition\Contracts\IsCondition;
use Squarebit\Volition\Contracts\Volitional;

class ObjectPropertyCondition implements IsCondition, IsFilamentCondition
{
    use FilamentCondition;

    public function __construct(
        public string $property,
        public mixed $value,
    ) {
    }

    public function passes(object $object): bool
    {
        return $object->{$this->property} === $this->value;
    }

    public function __toString(): string
    {
        return $this->property.' = '.$this->value;
    }

    public function validate(Volitional $object, bool $isValid): void
    {
        // You can throw an exception here
    }

    public static function getFilamentSchema(): ?array
    {
        return [
            TextInput::make('property')->required(),
            TextInput::make('value')->required(),
        ];
    }
}
