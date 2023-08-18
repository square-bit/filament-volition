<?php

namespace Squarebit\FilamentVolition\Tests\Support;

use Squarebit\Volition\Contracts\IsAction;
use Squarebit\Volition\Exception\ActionExecutionException;
use Throwable;

/**
 * @template-implements IsAction<string>
 */
class PrefixAction implements IsAction
{
    public function __construct(
        public string $prefix = ''
    ) {
    }

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
}
