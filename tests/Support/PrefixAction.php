<?php

namespace Squarebit\FilamentVolition\Tests\Support;

use Filament\Forms\Components\TextInput;
use Squarebit\FilamentVolition\Contracts\IsFilamentAction;
use Squarebit\FilamentVolition\Traits\FilamentAction;
use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Exception\ActionExecutionException;
use Throwable;

/**
 * @template-implements IsAction<string>
 */
class PrefixAction implements IsAction, IsFilamentAction
{
    use FilamentAction;

    public function __construct(
        public string $prefix = ''
    ) {}

    /**
     * @param  TestObject  $object
     *
     * @throws Throwable
     */
    public function execute(mixed $object): string
    {
        throw_if($object->property === $this->prefix, ActionExecutionException::class, static::class, $object::class);

        return $this->prefix.$object->property;
    }

    public function __toString(): string
    {
        return 'Prefix: '.$this->prefix;
    }

    public static function getFilamentSchema(): ?array
    {
        return [
            TextInput::make('prefix')->required(),
        ];
    }
}
