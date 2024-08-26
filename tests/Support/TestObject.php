<?php

namespace Squarebit\FilamentVolition\Tests\Support;

use Squarebit\Volition\Contracts\Volitional;
use Squarebit\Volition\Traits\HasVolition;

class TestObject implements Volitional
{
    use HasVolition;

    public function __construct(
        public string $property,
    ) {}
}
