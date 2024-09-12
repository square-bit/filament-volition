<?php

namespace Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Squarebit\FilamentVolition\Contracts\IsFilamentElement;
use Squarebit\FilamentVolition\Facades\FilamentVolition;
use Squarebit\FilamentVolition\Filament\Actions\CreateElementAction;
use Squarebit\FilamentVolition\Filament\Actions\EditElementAction;
use Squarebit\Volition\Models\Action;
use Squarebit\Volition\Models\Element;

abstract class ElementsRelationManager extends RelationManager
{
    /**
     * @return array<int, Block>
     */
    abstract protected function getBlocks(): array;

    public function form(Form $form): Form
    {
        $schema = $this->getBlocks();

        return count($schema) === 0 ? $form : $form->schema([
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
                Tables\Columns\TextColumn::make('payload')
                    ->label(__('Element'))
                    ->formatStateUsing(fn (IsFilamentElement $state) => $state->getLabel()),
                Tables\Columns\TextColumn::make('condition')
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
                Tables\Columns\ToggleColumn::make('enabled'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateElementAction::make(),
            ])
            ->actions([
                EditElementAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateElementAction::make(),
            ]);
    }
}
