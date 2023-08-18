<?php

namespace Squarebit\FilamentVolition\Tests\Support;

use Squarebit\FilamentVolition\Contracts\IsFilamentCondition;
use Squarebit\FilamentVolition\Elements\FilamentCondition;
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
        return;
    }
}
