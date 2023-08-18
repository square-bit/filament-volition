<?php

namespace Squarebit\FilamentVolition\Contracts;

interface IsFilamentElement
{
    public static function getLabel(): string;

    public static function getFilamentSchema(): ?array;

    public static function fromFilamentFormData(array $data): static;

    public function toFilamentFormData(): array;
}
