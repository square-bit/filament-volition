<?php

namespace Squarebit\FilamentVolition\Contracts;

use Filament\Forms\Components\Component;

interface IsFilamentElement
{
    public static function getLabel(): string;

    /**
     * @return array<int, Component>|null
     */
    public static function getFilamentSchema(): ?array;

    /**
     * @param  array<string, mixed>  $data
     * @return static
     */
    public static function fromFilamentFormData(array $data): static;

    /**
     * @return  array<string, mixed>
     */
    public function toFilamentFormData(): array;

    public function __toString(): string;
}
