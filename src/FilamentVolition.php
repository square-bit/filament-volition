<?php

namespace Squarebit\FilamentVolition;

use Filament\Forms\Components\Builder\Block;
use Illuminate\Support\Arr;
use Squarebit\FilamentVolition\Contracts\IsFilamentAction;
use Squarebit\FilamentVolition\Contracts\IsFilamentCondition;
use Squarebit\FilamentVolition\Contracts\IsFilamentElement;
use Squarebit\Volition\Contracts\Volitional;

class FilamentVolition
{
    /**
     * @var array<int, class-string<Volitional>>
     */
    protected array $volitionals = [];

    /**
     * @var array<int, class-string<IsFilamentCondition>>
     */
    protected array $conditions = [];

    /**
     * @var array<int, class-string<IsFilamentAction>>
     */
    protected array $actions = [];

    /**
     * <<<<<<< HEAD
     *
     * @param  array<class-string<Volitional>>|class-string<Volitional>  $volitionals
     * =======
     * @param  array<class-string<\Squarebit\Volition\Contracts\Volitional>>|class-string<Volitional>  $volitionals
     * >>>>>>> 232f5c049dfc88686fd26b8f84f817435237c68e
     * @return $this
     */
    public function registerVolitionals(array|string $volitionals): self
    {
        $this->volitionals = array_unique(array_merge($this->volitionals, Arr::wrap($volitionals)));

        return $this;
    }

    /**
     * @param  array<int, class-string<IsFilamentCondition>>|class-string<IsFilamentAction>  $condition
     * @return $this
     */
    public function registerConditions(array|string $condition): self
    {
        $this->conditions = array_unique(array_merge($this->conditions, Arr::wrap($condition)));

        return $this;
    }

    /**
     * @param  array<int, class-string<IsFilamentAction>>|class-string<IsFilamentAction>  $action
     * @return $this
     */
    public function registerActions(array|string $action): self
    {
        $this->actions = array_unique(array_merge($this->actions, Arr::wrap($action)));

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
     * @return array <int, class-string<IsFilamentCondition>>
     */
    public function conditions(): array
    {
        return $this->conditions;
    }

    /**
     * @return array <int, class-string<IsFilamentAction>>
     */
    public function actions(): array
    {
        return $this->actions;
    }

    /**
     * @param  array<int, class-string<IsFilamentElement>>  $payloads
     * @return array<int, Block>
     */
    protected function getFilamentBlocksFor(array $payloads): array
    {
        return array_filter(array_map(function (string $payloadClass): ?Block {
            $schema = $payloadClass::getFilamentSchema();

            return $schema === null ? null : Block::make($payloadClass)
                ->label($payloadClass::getLabel())
                ->schema($schema);
        }, $payloads
        ));
    }

    /**
     * @return array<int, Block>
     */
    public function getFilamentBlocksForConditions(): array
    {
        return $this->getFilamentBlocksFor($this->conditions());
    }

    /**
     * @return array<int, Block>
     */
    public function getFilamentBlocksForActions(): array
    {
        return $this->getFilamentBlocksFor($this->actions());
    }
}
