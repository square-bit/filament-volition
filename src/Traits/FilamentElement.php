<?php

namespace Squarebit\FilamentVolition\Traits;

trait FilamentElement
{
    public static function getLabel(): string
    {
        return class_basename(static::class);
    }

    public static function fromFilamentFormData(array $data): static
    {
        return new static(...$data);
    }

    public function toFilamentFormData(): array
    {
        return [[
            'type' => $this::class,
            'data' => json_decode(json_encode($this), true),
        ]];
    }
}
