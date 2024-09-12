<?php

namespace Squarebit\FilamentVolition;

use Filament\Forms\Components\Builder\Block;
use Illuminate\Support\Arr;
use ReflectionClass;
use Squarebit\FilamentVolition\Contracts\IsFilamentElement;
use Squarebit\Volition\Contracts\Volitional;
use Squarebit\Volition\Facades\Volition;

class FilamentVolition
{
    /**
     * @var array<int, class-string<Volitional>>
     */
    protected array $volitionals = [];

    /**
     * @param  array<class-string<Volitional>>|class-string<Volitional>  $volitionals
     *                                                                                 =======
     * @param  array<class-string<\Squarebit\Volition\Contracts\Volitional>>|class-string<Volitional>  $volitionals
     *                                                                                                               >>>>>>> 232f5c049dfc88686fd26b8f84f817435237c68e
     * @return $this
     */
    public function registerVolitionals(array|string $volitionals): self
    {
        $this->volitionals = array_unique(array_merge($this->volitionals, Arr::wrap($volitionals)));

        return $this;
    }

    /**
     * @return array <int, class-string<Volitional>>
     */
    public function volitionals(): array
    {
        return $this->volitionals;
    }

    /**
     * @param  array<int, class-string<IsFilamentElement>>  $payloads
     * @return array<int, Block>
     */
    protected function getFilamentBlocksFor(array $payloads): array
    {
        return collect($payloads)
            ->filter(
                fn (string $className) => (new ReflectionClass($className))
                    ->implementsInterface(IsFilamentElement::class)
            )
            ->map(function (string $payloadClass) {
                $schema = $payloadClass::getFilamentSchema();

                return $schema === null ? null : Block::make($payloadClass)
                    ->label($payloadClass::getLabel())
                    ->schema($schema);
            })
            ->filter()
            ->sortBy(fn (Block $block) => $block->getLabel())
            ->all();
    }

    /**
     * @return array<int, Block>
     */
    public function getFilamentBlocksForConditions(): array
    {
        return $this->getFilamentBlocksFor(Volition::getConditions());
    }

    /**
     * @return array<int, Block>
     */
    public function getFilamentBlocksForActions(): array
    {
        return $this->getFilamentBlocksFor(Volition::getActions());
    }
}
