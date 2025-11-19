<?php

namespace Squarebit\FilamentVolition\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\CreateAction;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers\ConditionsRelationManager;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers\ActionsRelationManager;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages\ListRules;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages\CreateRule;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages\EditRule;
use Filament\Panel;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Squarebit\FilamentVolition\Facades\FilamentVolition;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\Pages;
use Squarebit\FilamentVolition\Filament\Resources\RuleResource\RelationManagers;
use Squarebit\Volition\Models\Rule;

class RuleResource extends Resource
{
    protected static ?string $model = Rule::class;

    /**
     * @return Builder<Rule>
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount(['conditions', 'actions']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('applies_to')
                    ->translateLabel()
                    ->required()
                    ->options(array_combine(FilamentVolition::volitionals(), FilamentVolition::volitionals())),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('applies_to')->searchable(),
                TextColumn::make('conditions')
                    ->label(__('Conditions'))
                    ->badge()
                    ->getStateUsing(fn (Rule $record) => $record->conditions_count),
                TextColumn::make('actions')
                    ->label(__('Actions'))
                    ->badge()
                    ->getStateUsing(fn (Rule $record) => $record->actions_count),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ConditionsRelationManager::class,
            ActionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRules::route('/'),
            'create' => CreateRule::route('/create'),
            'edit' => EditRule::route('/{record}/edit'),
        ];
    }

    public static function getNavigationIcon(): ?string
    {
        return config('filament-volition.navigation-icon');
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-volition.navigation-group');
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return config('filament-volition.slug', 'volition');
    }
}
