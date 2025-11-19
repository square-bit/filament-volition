<?php

namespace Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Squarebit\FilamentVolition\Contracts\IsFilamentElement;
use Squarebit\FilamentVolition\Filament\Actions\CreateElementAction;
use Squarebit\FilamentVolition\Filament\Actions\EditElementAction;
use Squarebit\Volition\Models\Element;

abstract class ElementsRelationManager extends RelationManager
{
    /**
     * @return array<int, Block>
     */
    abstract protected function getBlocks(): array;

    public function form(Schema $form): Schema
    {
        $schema = $this->getBlocks();

        return count($schema) === 0 ? $form : $form->components([
            Builder::make('payload')
                ->addActionLabel(__('Add'))
                ->required()
                ->maxItems(1)
                ->hiddenLabel()
                ->columnSpanFull()
                ->blockPickerWidth('xl')
                ->blockPickerColumns(2)
                ->blockNumbers(false)
                ->reorderable(false)
                ->blocks($schema),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payload')
                    ->label(__('Element'))
                    ->formatStateUsing(fn (IsFilamentElement $state) => $state->getLabel()),
                TextColumn::make('condition')
                    ->label(__('Parameters'))
                    ->listWithLineBreaks(function (Element $record) {
                        /** @var IsFilamentElement $payload */
                        $payload = $record->payload;

                        return count(explode(PHP_EOL, $payload->__toString())) > 1;
                    })
                    ->getStateUsing(function (Element $record) {
                        /** @var IsFilamentElement $payload */
                        $payload = $record->payload;

                        return explode(PHP_EOL, $payload->__toString());
                    }),
                ToggleColumn::make('enabled'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateElementAction::make(),
            ])
            ->recordActions([
                EditElementAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateElementAction::make(),
            ]);
    }
}
