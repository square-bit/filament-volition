<?php

namespace Squarebit\FilamentVolition\Tests\Support;

use Filament\Forms\Components\TextInput;
use Squarebit\FilamentVolition\Contracts\IsFilamentAction;
use Squarebit\FilamentVolition\Traits\FilamentAction;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Traits\VolitionElement;

/**
 * @template-implements \Squarebit\Volition\Contracts\IsAction<string>
 */
class SuffixAction implements IsAction, IsFilamentAction
{
    use FilamentAction;
    use VolitionElement;

    public function __construct(
        public string $suffix = ''
    ) {}

    /**
     * @param  TestObject  $object
     */
    public function execute(mixed $object): string
    {
        return $object->property.$this->suffix;
    }

    public function __toString(): string
    {
        return 'Suffix: '.$this->suffix;
    }

    public static function getFilamentSchema(): ?array
    {
        return [
            TextInput::make('suffix')->required(),
        ];
    }
}
